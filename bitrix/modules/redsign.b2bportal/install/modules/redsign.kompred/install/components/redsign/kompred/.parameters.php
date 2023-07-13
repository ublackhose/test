<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arComponentParameters
 * @var array $arCurrentValues
 * @var string $componentPath
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$isIblockModuleIncluded = Loader::includeModule('iblock');

$arComponentParameters = [
    'GROUPS' => [
        'BASE' => [],
        'CREATE' => [
            'NAME' => Loc::getMessage('RS_K_P_GROUP_CREATE')
        ],
        'LIST' => [
            'NAME' => Loc::getMessage('RS_K_P_GROUP_LIST')
        ]
    ],
    'PARAMETERS' => []
];

$arComponentParameters['PARAMETERS']['SEF_MODE'] = [
    'list' => [
        'NAME' => Loc::getMessage('RS_KP_K_P_SEF_LIST'),
        'DEFAULT' => '',
        'VARIABLES' => []
    ],
    'create' => [
        'NAME' => Loc::getMessage('RS_KP_K_P_SEF_CREATE'),
        'DEFAULT' => 'create/',
        'VARIABLES' => []
    ],
    'edit' => [
        'NAME' => Loc::getMessage('RS_KP_K_P_SEF_EDIT'),
        'DEFAULT' => 'edit/#ID#',
        'VARIABLES' => ['ID', 'CODE']
    ],
    'download' => [
        'NAME' => Loc::getMessage('RS_KP_K_P_SEF_DOWNLOAD'),
        'DEFAULT' => 'download/#CODE#',
        'VARIABLES' => ['ID', 'CODE']
    ]
];

$arComponentParameters['PARAMETERS']['VARIABLE_ALIASES'] = [
    'ID' => [
        'NAME' => 'ID',
    ],
    'CODE' => [
        'NAME' => 'CODE',
    ],
    'ACTION' => [
        'NAME' => 'ACTION',
    ]
];

$arComponentParameters['PARAMETERS']['MAKE_SHORTLINK'] = [
    'PARENT' => 'CREATE',
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('RS_KP_K_P_MAKE_SHORTLINK'),
    'DEFAULT' => 'N'
];

$arComponentParameters['PARAMETERS']['LIST_PAGE_SIZE'] = [
    'PARENT' => 'LIST',
    'TYPE' => 'STRING',
    'NAME' => Loc::getMessage('RS_KP_K_P_PAGE_SIZE'),
    'DEFAULT' => '15'
];

$arComponentParameters['PARAMETERS']['LIST_USE_SEARCH'] = [
    'PARENT' => 'LIST',
    'TYPE' => 'CHECKBOX',
    'NAME' => Loc::getMessage('RS_KP_K_P_USE_SEARCH'),
    'DEFAULT' => 'N'
];


if ($isIblockModuleIncluded) {
    $arComponentParameters['PARAMETERS']['LIST_DATE_FORMAT'] = CIBlockParameters::GetDateFormat(
        Loc::getMessage('RS_KP_K_P_DATE_FORMAT'),
        'LIST'
    );
}
