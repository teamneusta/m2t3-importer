# Work in Progress - M2T3 - TYPO3 Importer

## Requirements

- php 7
- TYPO3 > 8.2
- team-neusta-gmbh/m2t3-elastictypo

## Explaination

- Import Magento groups to TYPO3 groups
- Import Magento categories to TYPO3 pages

## Installation

- add following to your composer.json

```javascript
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/teamneusta/m2t3-importer.git"
    }
  ],
  "require": {
    "TeamNeustaGmbH/m2t3-importer": "^1.0"
  }
}
```

- after that make an `composer update`  

## Configuration

- Needed Configuration for AdditionalConfiguration
```
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['groups']['index'] = 'magentypo';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['groups']['type'] = 'customer_group';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['groups']['pid'] = 2;

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['index'] = 'magentypo';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['type'] = 'category';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_importer']['category']['pid'] = '5';
```

Explain: for groups and category

| option | description | example
| ------------ | ------------- | -------------
| index | elastic index to the magentypo index | magentypo
| type | elastic index to the magento product type | content
| pid | pid to the user groups settings | 2

#### TYPOSCRIPT

Setup:

```
<INCLUDE_TYPOSCRIPT: source="FILE:EXT:m2t3_importer/Configuration/TypoScript/setup.txt">
```

### Usage

add category importer task in scheduler
add groups importer task in scheduler
