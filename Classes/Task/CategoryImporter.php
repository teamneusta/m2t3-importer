<?php
/**
 * This file is part of the TeamNeustaGmbH/m2t3 package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/BSD-3-Clause  BSD-3-Clause License
 */

declare(strict_types = 1);

namespace TeamNeustaGmbH\M2T3\Importer\Task;

use Elastica\Request;
use TeamNeustaGmbH\M2T3\Elastictypo\Domain\Model\Content;
use TeamNeustaGmbH\M2T3\Elastictypo\Domain\Model\ContentDocument;
use TeamNeustaGmbH\M2T3\Elastictypo\Domain\Repository\ContentRepository;
use TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService;
use TeamNeustaGmbH\M2T3\Elastictypo\Service\Typo3Service;
use TeamNeustaGmbH\M2T3\Importer\Domain\Model\FrontendUserGroup;
use TeamNeustaGmbH\M2T3\Importer\Domain\Model\Page;
use TeamNeustaGmbH\M2T3\Importer\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Class CategoryImporter
 *
 * @package TeamNeustaGmbH\M2T3\Importer\Task
 */
class CategoryImporter extends AbstractTask
{

    /**
     * elasticService
     *
     * @var \TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService
     */
    protected $elasticService;
    /**
     * pageRepository
     *
     * @var \TeamNeustaGmbH\M2T3\Importer\Domain\Repository\PageRepository
     */
    protected $pageRepository;
    /**
     * Typo3Service
     *
     * @var Typo3Service
     */
    protected $typo3Service;

    /**
     * This is the main method that is called when a task is executed
     * It MUST be implemented by all classes inheriting from this one
     * Note that there is no error handling, errors and failures are expected
     * to be handled and logged by the client implementations.
     * Should return TRUE on successful execution, FALSE on error.
     *
     * @return bool Returns TRUE on successful execution, FALSE on error
     */
    public function execute(): bool
    {
        $index = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['index'];
        $type = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['type'];
        $this->init();
        $results = $this->getAllGroupsFromElastic($index, $type);

        usort($results, function($a, $b) {
            return $a['_source']['path'] <=> $b['_source']['path'];
        });

        /** @var Page $rootPage */
        $rootPage = $this->pageRepository->findByUid(
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['pid']
        );

        if (!empty($rootPage) && !empty($results)) {
            foreach ($results as $itemType) {
                $item = $itemType['_source'];
                $id = (int)$item['id'];
                $path = explode('/', $item['path']);
                $parentId = $rootPage->getUid();
                if (count($path) > 1 && !empty($path[count($path)-2])) {
                    $parentPage = $this->pageRepository->findByCategoryId((int)$path[count($path)-2]);
                    if ($parentPage) {
                        $parentId = $parentPage->getUid();
                    }
                }


                if (!empty($id)) {
                    $model = $this->pageRepository->findByCategoryId($id);
                    if (!$model) {
                        $model = new Page();
                        $model->setTitle($item['name']);
                        $model->setPid($parentId);
                        $model->setDoktype(116);
                        $model->setUrl($item['path']);
                        $model->setCategoryId($id);
                        $this->pageRepository->add($model);
                    } else {
                        $model->setTitle($item['name']);
                        $model->setUrl($item['path']);
                        $model->setPid($parentId);
                        $this->pageRepository->update($model);
                    }
                }
            }

            /** @var PersistenceManager $persistenceManager */
            $persistenceManager = $this->typo3Service->objectManagerGet(PersistenceManager::class);
            $persistenceManager->persistAll();
        }

        return true;
    }

    /**
     * getAllGroupsFromElastic
     *
     * @param string $index
     * @param string $type
     * @return array
     */
    protected function getAllGroupsFromElastic(string $index, string $type): array
    {
        $client = $this->elasticService->getClient();

        $index = $client->getIndex($index);
        $type = $index->getType($type);

        $query = [
            'from' => 0,
            'size' => 9999
        ];

        $path = $index->getName().'/'.$type->getName().'/_search';

        $response = $client->request($path, Request::GET, $query);
        $responseArray = $response->getData();

        return !empty($responseArray['hits']['hits']) ? $responseArray['hits']['hits'] : [];
    }

    /**
     * init
     *
     * @return void
     */
    protected function init()
    {
        $this->injectElasticService(new ElasticService());
        $this->injectTypo3Service();
        $this->injectPageRepository();
    }

    /**
     * injectElasticService
     *
     * @param \TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService $elasticService
     * @return void
     */
    public function injectElasticService(\TeamNeustaGmbH\M2T3\Elastictypo\Service\ElasticService $elasticService)
    {
        $this->elasticService = $elasticService;
    }

    /**
     * injectPageRepository
     *
     * @param \TeamNeustaGmbH\M2T3\Importer\Domain\Repository\PageRepository $pageRepository
     * @return void
     */
    public function injectPageRepository(
        \TeamNeustaGmbH\M2T3\Importer\Domain\Repository\PageRepository $pageRepository = null
    ) {
        $this->pageRepository = $pageRepository ?: $this->typo3Service->objectManagerGet(
            \TeamNeustaGmbH\M2T3\Importer\Domain\Repository\PageRepository::class
        );
    }

    /**
     * injectTypo3Service
     *
     * @param \TeamNeustaGmbH\M2T3\Elastictypo\Service\Typo3Service $typo3Service
     * @return void
     */
    public function injectTypo3Service(
        \TeamNeustaGmbH\M2T3\Elastictypo\Service\Typo3Service $typo3Service = null
    ) {
        $this->typo3Service = $typo3Service ?: $this->typo3Service ?: new Typo3Service();
    }
}
