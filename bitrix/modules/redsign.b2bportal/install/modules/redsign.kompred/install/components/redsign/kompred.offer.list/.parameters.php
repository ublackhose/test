<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arComponentParameters
 * @var array $arCurrentValues
 * @var string $componentPath
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$isIblockModuleIncluded = Loader::includeModule('iblock');

$arComponentParameters = [
    'GROUPS' => [
        'BASE' => [],
    ],
    'PARAMETERS' => []
];

$arComponentParameters['PARAMETERS']['PAGE_SIZE'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOL_P_PAGE_SIZE'),
    'DEFAULT' => '15'
];

$arComponentParameters['PARAMETERS']['USE_SEARCH'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('RS_KP_KOL_P_USE_SEARCH'),
    'DEFAULT' => 'N'
];

if ($isIblockModuleIncluded) {
    $arComponentParameters['PARAMETERS']['DATE_FORMAT'] = CIBlockParameters::GetDateFormat(Loc::getMessage('RS_KP_KOL_P_DATE_FORMAT'), 'BASE');
}

$arComponentParameters['PARAMETERS']['DOWNLOAD_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOL_P_DOWNLOAD_URL'),
    'DEFAULT' => '/kompred/download/#CODE#/'
];

$arComponentParameters['PARAMETERS']['EDIT_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOL_P_EDIT_URL'),
    'DEFAULT' => '/kompred/edit/#ID#/'
];
