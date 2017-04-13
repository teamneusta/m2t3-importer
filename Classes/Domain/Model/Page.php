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

namespace TeamNeustaGmbH\M2T3\Importer\Domain\Model;

/**
 * Class Content
 *
 * @package TeamNeustaGmbH\M2T3\Importer\Domain\Model
 */
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * uid
     *
     * @var int
     */
    protected $uid;

    /**
     * pid
     *
     * @var int
     */
    protected $pid;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * doktype
     *
     * @var int
     */
    protected $doktype;

    /**
     * url
     *
     * @var string
     */
    protected $url;

    /**
     * categoryId
     *
     * @var int
     */
    protected $categoryId;

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getDoktype(): int
    {
        return $this->doktype;
    }

    /**
     * @param int $doktype
     */
    public function setDoktype(int $doktype)
    {
        $this->doktype = $doktype;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}
