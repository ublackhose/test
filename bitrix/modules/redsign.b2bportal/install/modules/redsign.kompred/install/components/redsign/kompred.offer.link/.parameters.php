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

$arComponentParameters['PARAMETERS']['CREATE_URL'] = [
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_KOL_P_CREATE_URL'),
    'DEFAULT' => ''
];
