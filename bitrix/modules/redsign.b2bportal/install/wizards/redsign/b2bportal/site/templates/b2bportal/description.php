<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

$arTemplate = [
    'SORT' => '1',
    'TYPE' => '',
    'NAME' => Loc::getMessage('RS.B2BPORTAL.TEMPLATE_NAME'),
    'DESCRIPTION' => Loc::getMessage('RS.B2BPORTAL.TEMPLATE_DESC'),
];
