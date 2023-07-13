<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Sale\Internals\OrderPropsTable;
use Redsign\B2BPortal\ParametersUtils;


/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!Loader::includeModule('redsign.devfunc'))
{
    return;
}
if (!Loader::includeModule('redsign.b2bportal'))
{
    return;
}
if (!Loader::includeModule('sale'))
{
    return;
}


$arProps = [];
$arPropsSort = [];
$arOrder = [
    'SORT' => 'ASC',
    'NAME' => 'ASC',
];
$arFilter = [
    '=ACTIVE' => 'Y',
    '!=UTIL' => 'Y',
    '=TYPE' => ['STRING', 'NUMBER'],
];
$arSelect = [
    '*'
];
$query = OrderPropsTable::query();
$query->setOrder($arOrder);
$query->setFilter($arFilter);
$query->setSelect($arSelect);
$res = $query->exec();
while ($row = $res->fetch())
{
    $arProps[$row['CODE']] = '[' . $row['ID'] . '] [' . $row['CODE'] . '] ' . $row['NAME'];
    $arPropsSort['PROPS_' . $row['CODE']] = '[' . $row['ID'] . '] [' . $row['CODE'] . '] ' . $row['NAME'];
}

ParametersUtils::addCommonParameters($arTemplateParameters, $arCurrentValues, array('sorter'));

$arTemplateParameters['USE_CLAIMS'] = [
    'PARENT' => '',
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_USE_CLAIMS'),
    'DEFAULT' => 'Y'
];

$arTemplateParameters['ADD_CLAIM_PATH'] = [
    'PARENT' => 'URL_TEMPLATES',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_ADD_CLAIM'),
    'DEFAULT' => '/personal/claims/?ID=0&edit=1&UF_ORDER_ID=#ORDER_NUMBER#'
];

$arTemplateParameters['CLAIMS_PATH'] = [
    'PARENT' => 'URL_TEMPLATES',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_CLAIMS'),
    'DEFAULT' => '/personal/claims/?UF_ORDER_ID=#ORDER_NUMBER#'
];

$arTemplateParameters['CLAIM_DETAIL'] = [
    'PARENT' => 'URL_TEMPLATES',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_CLAIM_DETAIL'),
    'DEFAULT' => '/personal/claims/?ID=#ID#&edit=1'
];

$arTemplateParameters['URL_TO_ADD'] = [
    'PARENT' => 'PROFILE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_URL_TO_ADD'),
    'DEFAULT' => ''
];

$arTemplateParameters['COMPANIES_HEADERS'] = [
    'PARENT' => 'PROFILE',
    'TYPE' => 'LIST',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_COMPANIES_HEADERS'),
    'VALUES' => $arProps,
    'MULTIPLE' => 'Y',
];

$arTemplateParameters['COMPANIES_HEADERS_SORT'] = [
    'PARENT' => 'PROFILE',
    'TYPE' => 'LIST',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_COMPANIES_HEADERS_SORT'),
    'VALUES' => $arPropsSort,
    'MULTIPLE' => 'Y',
];

$iblockTypes = CIBlockParameters::GetIBlockTypes(['-' => ' ']);

$iblocks = [];
$iblocksIterator = CIBlock::GetList(
    ['SORT' => 'ASC'],
    [
        'SITE_ID' => $_REQUEST['site'],
        'TYPE' => ($arCurrentValues['DOCUMENTS_IBLOCK_TYPE'] !== '-' ? $arCurrentValues['DOCUMENTS_IBLOCK_TYPE'] : '')
    ]
);

while ($iblockData = $iblocksIterator->fetch())
{
    $iblocks[$iblockData['ID']] = '[' . $iblockData['ID'] . '] ' . $iblockData['NAME'];
}
unset($iblockData);

$arTemplateParameters['DOCUMENTS_IBLOCK_TYPE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage('SPS_PARAMETERS_DOCUMENTS_IBLOCK_TYPE'),
    'TYPE' => 'LIST',
    'VALUES' => $iblockTypes,
    'DEFAULT' => '-',
    'REFRESH' => 'Y'
];
$arTemplateParameters['DOCUMENTS_IBLOCK_ID'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::getMessage("SPS_PARAMETERS_DOCUMENTS_IBLOCK_ID"),
    'TYPE' => 'LIST',
    'VALUES' => $iblocks,
    'DEFAULT' => '',
    'REFRESH' => 'Y',
];

unset($iblockTypes, $iblocks);
