<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters['ADD_COMPANY_URL'] = [
    'NAME' => Loc::getMessage('RS_B2BPORTAL_SPPS_ADD_COMPANY_URL'),
    'TYPE' => 'STRING',
];
