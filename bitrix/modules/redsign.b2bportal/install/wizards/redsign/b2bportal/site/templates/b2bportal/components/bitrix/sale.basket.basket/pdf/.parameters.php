<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters = [
    'ARTICLE_PROPERTY' => [
        'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_PARAMETERS_ARTICLE_PROPERTY'),
        'TYPE' => 'STRING'
    ]
];
