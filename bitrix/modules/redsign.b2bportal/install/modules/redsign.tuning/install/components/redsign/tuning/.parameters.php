<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arComponentParameters
 * @var array $arCurrentValues
 * @var string $componentPath
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arComponentParameters = array(
    'PARAMETERS' => array(
        'FILE_OPTIONS' => array(
            'NAME' => 'FILE_OPTIONS',
            'TYPE' => 'STRING',
        ),
        'FILE_COLORS' => array(
            'NAME' => 'FILE_COLORS',
            'TYPE' => 'STRING',
        ),
    )
);
