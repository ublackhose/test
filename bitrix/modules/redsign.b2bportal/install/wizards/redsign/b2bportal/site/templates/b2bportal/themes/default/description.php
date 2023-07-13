<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

$arTemplate = array(
    "NAME" => GetMessage("CPST_DEFAULT"),
    "SORT" => 600
);
