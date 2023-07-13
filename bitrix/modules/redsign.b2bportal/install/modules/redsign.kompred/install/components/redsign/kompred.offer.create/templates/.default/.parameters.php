<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters['DEFAULT_LOGO'] = [
    'PARENT' => 'SOURCE',
    'NAME' => Loc::getMessage('RS_KP_KOC_P_DEFAULT_LOGO'),
    'TYPE' => 'STRING',
    'DEFAULT' => ''
];


$arTemplateParameters['DEFAULT_CONTACTS'] = [
    'PARENT' => 'SOURCE',
    'NAME' => Loc::getMessage('RS_KP_KOC_P_DEFAULT_CONTACTS'),
    'TYPE' => 'STRING',
    'DEFAULT' => ''
];
