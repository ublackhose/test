<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters['PROP_VENDOR_CODE'] = [
    'PARENT' => 'SOURCE',
    'NAME' => Loc::getMessage('RS_KP_KOS_P_PROP_VENDOR_CODE'),
    'TYPE' => 'STRING',
    'DEFAULT' => 'ARTNUMBER'
];
