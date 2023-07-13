<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters['ORDER_PATH'] = [
    'PARENT' => 'URL_TEMPLATES',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('SUP_PARAMETERS_ORDER_PATH'),
    'DEFAULT' => '/personal/orders/#ORDER_NUMBER#/'
];
