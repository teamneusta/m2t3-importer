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

namespace TeamNeustaGmbH\M2T3\Importer\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class PageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * findByCategoryId
     *
     * @param int $categoryId
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByCategoryId(int $categoryId)
    {
        $query = $this->createQuery();
        return $query->matching($query->equals('categoryId', $categoryId))->execute()->getFirst();
    }

    public function initializeObject()
    {
        /** @var $defaultQuerySettings Typo3QuerySettings */
        $defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // don't add the pid constraint
        $defaultQuerySettings->setRespectStoragePage(false);
        // don't add sys_language_uid constraint
        $defaultQuerySettings->setRespectSysLanguage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }
}
