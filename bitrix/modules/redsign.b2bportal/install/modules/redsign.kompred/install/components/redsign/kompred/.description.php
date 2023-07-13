<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arComponentDescription = [
    'NAME' => Loc::getMessage('RS_KP_COMP_K_TITLE'),
    'DESCRIPTION' => Loc::getMessage('RS_KP_COMP_K_DESC'),
    'ICON' => '',
    'PATH' => [
        'ID' => 'redsign',
        'NAME' => Loc::getMessage('RS_COMP_TITLE'),
        'CHILD' => [
            'ID' => 'redsign_kompred',
            'NAME' => Loc::getMessage('RS_KP_COMP_TITLE'),
        ]
    ],
];
