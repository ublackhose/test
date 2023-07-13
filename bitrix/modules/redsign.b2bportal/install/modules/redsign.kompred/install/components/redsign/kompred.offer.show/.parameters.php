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
        'SOURCE' => [],
        'VISUAL' => []
    ],
    'PARAMETERS' => []
];

$arComponentParameters['PARAMETERS']['LIST_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOS_P_LIST_URL'),
    'DEFAULT' => ''
];

$arComponentParameters['PARAMETERS']['DOWNLOAD_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOS_P_DOWNLOAD_URL'),
    'DEFAULT' => ''
];

$arComponentParameters['PARAMETERS']['EDIT_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOS_P_EDIT_URL'),
    'DEFAULT' => ''
];
