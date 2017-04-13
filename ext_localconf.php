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

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Add hotel lookup reindexer scheduler task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TeamNeustaGmbH\M2T3\Importer\Task\GroupImporter::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:groupImporter.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:groupImporter.description'
);

// Add category importer scheduler task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\TeamNeustaGmbH\M2T3\Importer\Task\CategoryImporter::class] = array(
    'extension' => $_EXTKEY,
    'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:categoryImporter.name',
    'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:categoryImporter.description'
);
