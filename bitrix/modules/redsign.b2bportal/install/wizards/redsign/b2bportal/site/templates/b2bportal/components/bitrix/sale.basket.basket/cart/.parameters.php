<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arTemplateParameters['ENABLE_PREVIEW_PICTURE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_PARAMETERS_ENABLE_PREVIEW_PICTURE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

$arTemplateParameters['ARTICLE_PROPERTY'] = [
    'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_PARAMETERS_ARTICLE_PROPERTY'),
    'TYPE' => 'STRING'
];

$arTemplateParameters['PDF_PATH'] = [
    'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_PARAMETERS_PDF_PATH'),
    'TYPE' => 'STRING',
    'DEFAULT' => '/personal/cart/pdf.php'
];

$arTemplateParameters['USE_STORE'] = [
    "PARENT" => "STORE_SETTINGS",
    "NAME" => Loc::getMessage("RS_B2BPORTAL_SBB_PARAMETERS_USE_STORE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "REFRESH" => "Y",
];

if ($arCurrentValues['USE_STORE'] == 'Y' && Loader::includeModule('catalog'))
{
    $stores = [];

    $storeIterator = CCatalogStore::GetList(
        array(),
        array('ISSUING_CENTER' => 'Y'),
        false,
        false,
        array('ID', 'TITLE')
    );

    while ($store = $storeIterator->GetNext())
    {
        $stores[$store['ID']] = "[" . $store['ID'] . "] " . $store['TITLE'];
    }

    $arTemplateParameters['STORES'] = [
        'PARENT' => 'STORE_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_PARAMETERS_USE_STORES'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => $stores,
        'ADDITIONAL_VALUES' => 'Y'
    ];
}

$arTemplateParameters['SHOW_QUANTITY'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('RS_B2BPORTAL_SBB_SHOW_MAX_QUANTITY'),
    'TYPE' => 'LIST',
    'REFRESH' => 'Y',
    'MULTIPLE' => 'N',
    'VALUES' => array(
        'N' => Loc::getMessage('RS_B2BPORTAL_SBB_SHOW_MAX_QUANTITY_N'),
        'Y' => Loc::getMessage('RS_B2BPORTAL_SBB_SHOW_MAX_QUANTITY_Y'),
        'M' => Loc::getMessage('RS_B2BPORTAL_SBB_SHOW_MAX_QUANTITY_M')
    ),
    'DEFAULT' => array('N')
);

if (isset($arCurrentValues['SHOW_QUANTITY']))
{
    if ($arCurrentValues['SHOW_QUANTITY'] === 'Y')
    {
        $arTemplateParameters['MAX_QUANTITY'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_MAX_QUANTITY'),
            'TYPE' => 'STRING',
            'DEFAULT' => '500'
        ];
    }
    elseif ($arCurrentValues['SHOW_QUANTITY'] === 'M')
    {
        $arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_RELATIVE_QUANTITY_FACTOR'),
            'TYPE' => 'STRING',
            'DEFAULT' => '100'
        ];
        $arTemplateParameters['MESS_RELATIVE_QUANTITY_MANY'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_RELATIVE_QUANTITY_MANY'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
        ];
        $arTemplateParameters['MESS_RELATIVE_QUANTITY_FEW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_RELATIVE_QUANTITY_FEW'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
        ];
    }
}

$arTemplateParameters['EXPORT_TYPES'] = [
    'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_EXPORT_TYPES'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => [
        'xlsx' => 'xlsx',
        'csv' => 'csv',
        'ods' => 'ods'
    ],
    'DEFAULT' => ['xlsx', 'csv', 'ods']
];


if (Loader::includeModule('redsign.kompred'))
{
    $arTemplateParameters['KOMPRED_CREATE_URL'] = [
        'NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_MESS_KOMPRED_CREATE_URL'),
        'TYPE' => 'STRING',
        'DEFAULT' => '/personal/kompred/create/'
    ];
}
