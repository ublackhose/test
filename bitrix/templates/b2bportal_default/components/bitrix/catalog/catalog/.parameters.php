<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\ParametersUtils;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

if (
    !Loader::includeModule('iblock')
    || !Loader::includeModule('catalog')
    || !Loader::includeModule('redsign.devfunc')
    || !Loader::includeModule('redsign.b2bportal')
) {
    return;
}

$usePropertyFeatures = Bitrix\Iblock\Model\PropertyFeature::isEnabledFeatures();
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

$arSKU = false;
$boolSKU = false;
$filterDataValues = array();
if ($iblockExists) {
    $arSKU = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
    $boolSKU = !empty($arSKU) && is_array($arSKU);
    $filterDataValues['iblockId'] = (int)$arCurrentValues['IBLOCK_ID'];
    if ($boolSKU) {
        $filterDataValues['offersIblockId'] = $arSKU['IBLOCK_ID'];
    }
}

$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList((int)$arCurrentValues['IBLOCK_ID']);
$arCatalog = \CCatalog::GetByID($arCurrentValues['IBLOCK_ID']);
if (IntVal($arCatalog["OFFERS_IBLOCK_ID"])) {
    $listProp2 = RSDevFuncParameters::GetTemplateParamsPropertiesList((int)$arCatalog['OFFERS_IBLOCK_ID']);
}

$arPrices = [];
$arOrder = ['SORT' => 'ASC'];
$arFilter = [];
$rsPrice = \CCatalogGroup::GetList($arOrder, $arFilter);
while ($arr = $rsPrice->Fetch()) {
    $arPrices[$arr['NAME']] = '[' . $arr['NAME'] . '] ' . $arr['NAME_LANG'];
}

ParametersUtils::addCommonParameters($arTemplateParameters, $arCurrentValues, array('sorter'));

$defaultValue = array('-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY'));

$detailShowedProperty = [];
if ($usePropertyFeatures) {
    if ($iblockExists) {
        $detailShowedProperty = Bitrix\Iblock\Model\PropertyFeature::getDetailPageShowPropertyCodes(
            $arCurrentValues['IBLOCK_ID'],
            ['CODE' => 'Y']
        );
        if ($detailShowedProperty === null)
            $detailShowedProperty = [];
    }
} else {
    if (!empty($arCurrentValues['DETAIL_PROPERTY_CODE']) && is_array($arCurrentValues['DETAIL_PROPERTY_CODE'])) {
        $detailShowedProperty = $arCurrentValues['DETAIL_PROPERTY_CODE'];
    }
}

$arTemplateParameters['FILTER_PROPERTY_CODE'] = [
    'PARENT' => 'FILTER_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_FILTER_PROPERTY_CODE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $listProp['SNL'],
    'REFRESH' => 'Y',
];

$arTemplateParameters['FILTER_PRICE_CODE'] = [
    'PARENT' => 'FILTER_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_FILTER_PRICE_CODE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $arPrices,
];

$arTemplateParameters['FILTER_ENABLE_HIDE_NOT_AVAILABLE'] = [
    'PARENT' => 'FILTER_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_FILTER_ENABLE_HIDE_NOT_AVAILABLE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
];

$arTemplateParameters['PROP_CODE_MORE_PHOTO'] = [
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_PROP_CODE_MORE_PHOTO'),
    'TYPE' => 'LIST',
    'VALUES' => $listProp['F'],
];

$arTemplateParameters['PROP_CODE_MODIFICATIONS'] = [
    'PARENT' => 'DETAIL_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_PROP_CODE_MODIFICATIONS'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $listProp2['SNL'],
];

if (!$usePropertyFeatures) {
    $arTemplateParameters['PROP_CODE_ARTICLE'] = [
        'NAME' => Loc::getMessage('RS_B2B_C_P_PROP_CODE_ARTICLE'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp['SNL'],
        'REFRESH' => 'N',
    ];

    $arTemplateParameters['OFFERS_PROP_CODE_ARTICLE'] = [
        'NAME' => Loc::getMessage('RS_B2B_C_P_OFFERS_PROP_CODE_ARTICLE'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp2['SNL'],
        'REFRESH' => 'N',
    ];

    $arTemplateParameters['PROP_CODE_BRAND'] = [
        'NAME' => Loc::getMessage('RS_B2B_C_P_PROP_CODE_BRAND'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp['SNL'],
        'REFRESH' => 'N',
    ];
}

$arTemplateParameters['LIST_ENABLE_PREVIEW_PICTURE'] = [
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_ENABLE_PREVIEW_PICTURE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

$arTemplateParameters['LABEL_PROP'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('RS_B2B_C_P_LABEL_PROP'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'ADDITIONAL_VALUES' => 'N',
    'REFRESH' => 'Y',
    'VALUES' => $listProp['L']
);


if (isset($arCurrentValues['LABEL_PROP']) && count($arCurrentValues['LABEL_PROP'])) {
    foreach ($arCurrentValues['LABEL_PROP'] as $propCode) {
        $arTemplateParameters['LABEL_PROP_MODIFIER_' . $propCode] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('RS_B2B_C_P_LABEL_PROP_MODIFIER', [
                "#PROP_NAME#" => $listProp['L'][$propCode] ?? '',
            ]),
            'TYPE' => 'LIST',
            'VALUES' => [
                'primary' => 'primary',
                'secondary' => 'secondary',
                'success' => 'success',
                'danger' => 'danger',
                'warning' => 'warning',
                'info' => 'info',
                'light' => 'light',
                'dark' => 'dark'
            ],
            'DEFAULT' => 'primary'
        ];
    }
}

if (isset($arCurrentValues['LIST_ENABLE_PREVIEW_PICTURE']) && $arCurrentValues['LIST_ENABLE_PREVIEW_PICTURE'] === 'Y') {
    $arTemplateParameters['LIST_PREVIEW_PICTURE_SWITCHER'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_PREVIEW_PICTURE_SWITCHER'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        'REFRESH' => 'Y'
    ];
}

if ($boolSKU) {
    $arAllOfferPropList = array();
    $arFileOfferPropList = $arTreeOfferPropList = $defaultValue;
    $rsProps = CIBlockProperty::GetList(
        array('SORT' => 'ASC', 'ID' => 'ASC'),
        array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
    );
    while ($arProp = $rsProps->Fetch()) {
        if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
            continue;
        $arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
        $strPropName = '[' . $arProp['ID'] . ']' . ('' != $arProp['CODE'] ? '[' . $arProp['CODE'] . ']' : '') . ' ' . $arProp['NAME'];
        if ('' == $arProp['CODE'])
            $arProp['CODE'] = $arProp['ID'];
        $arAllOfferPropList[$arProp['CODE']] = $strPropName;
        if ('F' == $arProp['PROPERTY_TYPE'])
            $arFileOfferPropList[$arProp['CODE']] = $strPropName;
        if ('N' != $arProp['MULTIPLE'])
            continue;
        if (
            'L' == $arProp['PROPERTY_TYPE']
            || 'E' == $arProp['PROPERTY_TYPE']
            || ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
        )
            $arTreeOfferPropList[$arProp['CODE']] = $strPropName;
    }

    $arTemplateParameters['OFFER_TREE_PROPS'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('RS_B2B_C_P_OFFER_TREE_PROPS'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'ADDITIONAL_VALUES' => 'N',
        'REFRESH' => 'N',
        'DEFAULT' => '-',
        'VALUES' => $arTreeOfferPropList
    );
}

$arTemplateParameters['SHOW_MAX_QUANTITY'] = [
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY'),
    'TYPE' => 'LIST',
    'REFRESH' => 'Y',
    'MULTIPLE' => 'N',
    'VALUES' => [
        'N' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_N'),
        'Y' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_Y'),
        'M' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_M')
    ],
    'DEFAULT' => ['N']
];

if (isset($arCurrentValues['SHOW_MAX_QUANTITY'])) {
    if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'Y') {
        $arTemplateParameters['MAX_QUANTITY'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_MAX_QUANTITY'),
            'TYPE' => 'STRING',
            'DEFAULT' => '500'
        ];
        $arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_RELATIVE_QUANTITY_FACTOR_COLOR'),
            'TYPE' => 'STRING',
            'DEFAULT' => '100'
        ];
    } elseif ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'M') {
        $arTemplateParameters['RELATIVE_QUANTITY_FACTOR'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_RELATIVE_QUANTITY_FACTOR'),
            'TYPE' => 'STRING',
            'DEFAULT' => '100'
        ];
        $arTemplateParameters['MESS_RELATIVE_QUANTITY_MANY'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_MANY_DEFAULT')
        ];
        $arTemplateParameters['MESS_RELATIVE_QUANTITY_FEW'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW'),
            'TYPE' => 'STRING',
            'DEFAULT' => Loc::getMessage('CP_BC_TPL_MESS_RELATIVE_QUANTITY_FEW_DEFAULT')
        ];
    }
}

$arTemplateParameters['SECTIONS_VIEW'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('CP_BC_TPL_MESS_SECTIONS_VIEW'),
    'TYPE' => 'LIST',
    'DEFAULT' => 'lines',
    'VALUES' => [
        'lines' => Loc::getMessage('CP_BC_TPL_MESS_SECTIONS_VIEW_LINES'),
        'blocks' => Loc::getMessage('CP_BC_TPL_MESS_SECTIONS_VIEW_BLOCKS'),
        'filter' => Loc::getMessage('CP_BC_TPL_MESS_SECTIONS_VIEW_FILTER'),
        'blocks_with_filter' => Loc::getMessage('CP_BC_TPL_MESS_SECTIONS_VIEW_BLOCKS_WITH_FILTER'),
    ]
];

$arTemplateParameters['SECTION_TEMPLATE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('CP_BC_TPL_MESS_SECTION_TEMPLATE'),
    'TYPE' => 'LIST',
    'DEFAULT' => '.default',
    'ADDITIONAL_VALUES' => 'Y',
    'VALUES' => [
        '.default' => Loc::getMessage('CP_BC_TPL_MESS_SECTION_TEMPLATE_DEFAULT'),
        'showcase' => Loc::getMessage('CP_BC_TPL_MESS_SECTION_TEMPLATE_SHOWCASE'),
    ]
];

if (!empty($detailShowedProperty)) {
    $arTemplateParameters['DETAIL_LINES_PROPERTIES'] = [
        'PARENT' => 'DETAIL_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_LINES_PROPERTIES'),
        'TYPE' => 'LIST',
        'VALUES' => $defaultValue + $listProp['ALL'],
        'REFRESH' => 'Y',
        'MULTIPLE' => 'Y',
        'DEFAULT' => '-',
    ];
}

$arTemplateParameters['LIST_USE_EXPORT'] = [
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_USE_EXPORT'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['LIST_USE_EXPORT'] === 'Y') {
    $arTemplateParameters['LIST_EXPORT_ACTION_VARIABLE'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_EXPORT_ACTION_VARIABLE'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'export'
    ];

    $arTemplateParameters['LIST_EXPORT_TYPES'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_EXPORT_TYPES'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => [
            '-' => Loc::getMessage('CP_BC_TPL_PROP_EMPTY'),
            'xlsx' => 'xlsx',
            'csv' => 'csv',
            'ods' => 'ods'
        ],
        'DEFAULT' => ['xlsx', 'csv', 'ods']
    ];
}

$arTemplateParameters['LIST_ADD_PREVIEW_THUMBNAIL'] = [
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => Loc::getMessage('RS_B2B_C_P_ADD_PREVIEW_THUMBNAIL'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

if (
    !isset($arCurrentValues['LIST_ADD_PREVIEW_THUMBNAIL']) ||
    $arCurrentValues['LIST_ADD_PREVIEW_THUMBNAIL'] === 'Y'
) {
    $arTemplateParameters['LIST_PREVIEW_THUMBNAIL_WIDTH'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_ADD_PREVIEW_THUMBNAIL_WIDTH'),
        'TYPE' => 'STRING',
        'DEFAULT' => 60
    ];

    $arTemplateParameters['LIST_PREVIEW_THUMBNAIL_HEIGHT'] = [
        'PARENT' => 'LIST_SETTINGS',
        'NAME' => Loc::getMessage('RS_B2B_C_P_ADD_PREVIEW_THUMBNAIL_HEIGHT'),
        'TYPE' => 'STRING',
        'DEFAULT' => 60
    ];
}
