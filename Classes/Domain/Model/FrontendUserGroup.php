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
class FrontendUserGroup extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
{
    /**
     * @param int $uid
     */
    public function setUid(int $uid)
    {
        $this->uid = $uid;
    }
}
