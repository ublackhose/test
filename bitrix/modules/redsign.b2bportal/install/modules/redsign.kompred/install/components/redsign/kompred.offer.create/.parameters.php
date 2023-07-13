<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arComponentParameters
 * @var array $arCurrentValues
 * @var string $componentPath
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arComponentParameters = [
    'GROUPS' => [
        'BASE' => [],
    ],
    'PARAMETERS' => []
];

$arComponentParameters['PARAMETERS']['EDIT_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOC_P_EDIT_URL'),
    'DEFAULT' => ''
];

$arComponentParameters['PARAMETERS']['DOWNLOAD_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOC_P_DOWNLOAD_URL'),
    'DEFAULT' => ''
];

$arComponentParameters['PARAMETERS']['MAKE_SHORTLINK'] = [
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('RS_KP_KOC_P_EDIT_MAKE_SHORTLINK'),
    'DEFAULT' => 'Y'
];
