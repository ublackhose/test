<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$priceGroups = [];
if (Loader::includeModule('catalog')) {
    $priceGroupsIterator = \Bitrix\Catalog\GroupTable::getList([
        'order' => ['SORT' => 'ASC'],
        'select' => ['ID', 'NAME', 'TITLE' => 'CURRENT_LANG.NAME']
    ]);
    while ($group = $priceGroupsIterator->fetch()) {
        $priceGroups[$group['NAME']] = '[' . $group['NAME'] . '] ' . $group['TITLE'];
    }
}

$arTemplateParameters['SHOW_INPUT'] = [
    'NAME' => Loc::getMessage('TP_BST_SHOW_INPUT'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y',
];

$arTemplateParameters['INPUT_ID'] = [
    'NAME' => Loc::getMessage('TP_BST_INPUT_ID'),
    'TYPE' => 'STRING',
    'DEFAULT' => 'title-search-input',
];

$arTemplateParameters['CONTAINER_ID'] = [
    'NAME' => Loc::getMessage('TP_BST_CONTAINER_ID'),
    'TYPE' => 'STRING',
    'DEFAULT' => 'title-search',
];

$arTemplateParameters['PROP_CODE_ARTICLE'] = [
    'NAME' => Loc::getMessage('TP_BST_PROP_CODE_ARTICLE'),
    'TYPE' => 'STRING',
    'DEFAULT' => 'ARTNUMBER'
];

$arTemplateParameters['PRICE_CODE'] = [
    'NAME' => Loc::getMessage('TP_BST_PRICE_CODE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $priceGroups,
    'ADDITIONAL_VALUES' => 'Y',
];

$arTemplateParameters['PRICE_VAT_INCLUDE'] = [
    'NAME' => Loc::getMessage('TP_BST_PRICE_VAT_INCLUDE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y'
];

$arTemplateParameters['CONVERT_CURRENCY'] = [
    'NAME' => Loc::getMessage('TP_BST_CONVERT_CURRENCY'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y',
];

if ($arCurrentValues['CONVERT_CURRENCY'] === 'Y' && Loader::includeModule('currency')) {
    $currencies = \Bitrix\Currency\CurrencyManager::getCurrencyList();

    $arTemplateParameters['CURRENCY_ID'] = [
        'NAME' => Loc::getMessage('TP_BST_CURRENCY_ID'),
        'TYPE' => 'LIST',
        'VALUES' => $currencies,
        'DEFAULT' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
        'ADDITIONAL_VALUES' => 'Y',
    ];
}
