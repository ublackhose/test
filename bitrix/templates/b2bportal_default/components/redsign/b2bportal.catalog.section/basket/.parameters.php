<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\Iblock\PropertyFeature;
use Redsign\B2BPortal\ParametersUtils;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!Loader::includeModule('redsign.devfunc'))
{
    return;
}
if (!Loader::includeModule('redsign.b2bportal'))
{
    return;
}
if (!Loader::includeModule('catalog'))
{
    return;
}

$arSKU = false;
$boolSKU = false;
$filterDataValues = array();
if ((isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
    $arSKU = CCatalogSku::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
    $boolSKU = !empty($arSKU) && is_array($arSKU);
    $filterDataValues['iblockId'] = (int)$arCurrentValues['IBLOCK_ID'];
    if ($boolSKU)
    {
        $filterDataValues['offersIblockId'] = $arSKU['IBLOCK_ID'];
    }



print_r($arCurrentValues);

$listProp = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCurrentValues['IBLOCK_ID']);
$arCatalog = \CCatalog::GetByID($arCurrentValues['IBLOCK_ID']);

if (IntVal($arCatalog["OFFERS_IBLOCK_ID"]))
{
    $listProp2 = RSDevFuncParameters::GetTemplateParamsPropertiesList($arCatalog['OFFERS_IBLOCK_ID']);
}


ParametersUtils::addCommonParameters($arTemplateParameters, $arCurrentValues, array('sorter'));
}
if (!PropertyFeature::isEnabledFeatures())
{
    $arTemplateParameters['PROP_CODE_ARTICLE'] = [
        'NAME' => Loc::getMessage('RS.B2BPORTAL.CATALOG_PARAMETERS.PROP_CODE_ARTICLE'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp['SNL'],
        'REFRESH' => 'N',
    ];

    $arTemplateParameters['OFFERS_PROP_CODE_ARTICLE'] = [
        'NAME' => Loc::getMessage('RS.B2BPORTAL.CATALOG_PARAMETERS.OFFERS_PROP_CODE_ARTICLE'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp2['SNL'],
        'REFRESH' => 'N',
    ];

    $arTemplateParameters['PROP_CODE_BRAND'] = [
        'NAME' => Loc::getMessage('RS.B2BPORTAL.CATALOG_PARAMETERS.PROP_CODE_BRAND'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'N',
        'VALUES' => $listProp['SNL'],
        'REFRESH' => 'N',
    ];
}

$arTemplateParameters['ENABLE_PREVIEW_PICTURE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('RS_B2B_CS_P_ENABLE_PREVIEW_PICTURE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

if (isset($arCurrentValues['ENABLE_PREVIEW_PICTURE']) && $arCurrentValues['ENABLE_PREVIEW_PICTURE'] === 'Y')
{
    $arTemplateParameters['PREVIEW_PICTURE_SWITCHER'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('RS_B2B_CS_P_PREVIEW_PICTURE_SWITCHER'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y',
        'REFRESH' => 'Y'
    ];
}


$arTemplateParameters['LABEL_PROP'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => Loc::getMessage('CP_BC_LABEL_PROP'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'ADDITIONAL_VALUES' => 'N',
    'REFRESH' => 'Y',
    'VALUES' => $listProp['L']
);
if (isset($arCurrentValues['LABEL_PROP']) && count($arCurrentValues['LABEL_PROP']))
{
    foreach ($arCurrentValues['LABEL_PROP'] as $propCode)
    {
        $arTemplateParameters['LABEL_PROP_MODIFIER_' . $propCode] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_LABEL_PROP_MODIFIER', [
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

if ($boolSKU)
{
    $arAllOfferPropList = array();
    $arFileOfferPropList = $arTreeOfferPropList = $defaultValue;
    $rsProps = CIBlockProperty::GetList(
        array('SORT' => 'ASC', 'ID' => 'ASC'),
        array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
    );
    while ($arProp = $rsProps->Fetch())
    {
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
        'NAME' => GetMessage('CP_BCS_TPL_OFFER_TREE_PROPS'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'ADDITIONAL_VALUES' => 'N',
        'REFRESH' => 'N',
        'DEFAULT' => '-',
        'VALUES' => $arTreeOfferPropList
    );
}

$arTemplateParameters['USE_STORE'] = [
    "PARENT" => "VISUAL",
    "NAME" => Loc::getMessage("RS_B2B_CS_P_USE_STORE"),
    "TYPE" => "CHECKBOX",
    "DEFAULT" => "N",
    "REFRESH" => "Y",
    "PARENT" => 'VISUAL'
];

if (isset($arCurrentValues['USE_STORE']) && $arCurrentValues['USE_STORE'] == 'Y' && Loader::includeModule('catalog'))
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
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('RS_B2B_CS_P_STORES'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => $stores,
        'ADDITIONAL_VALUES' => 'Y'
    ];
}

$arTemplateParameters['SHOW_MAX_QUANTITY'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('CP_BC_TPL_SHOW_MAX_QUANTITY'),
    'TYPE' => 'LIST',
    'REFRESH' => 'Y',
    'MULTIPLE' => 'N',
    'VALUES' => array(
        'N' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_N'),
        'Y' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_Y'),
        'M' => Loc::getMessage('CP_BC_TPL_SHOW_MAX_QUANTITY_M')
    ),
    'DEFAULT' => array('Y')
);

if (isset($arCurrentValues['SHOW_MAX_QUANTITY']))
{
    if ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'Y')
    {
        $arTemplateParameters['MAX_QUANTITY'] = [
            'PARENT' => 'VISUAL',
            'NAME' => Loc::getMessage('CP_BC_TPL_MAX_QUANTITY'),
            'TYPE' => 'STRING',
            'DEFAULT' => '500'
        ];
    }
    elseif ($arCurrentValues['SHOW_MAX_QUANTITY'] === 'M')
    {
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

$arTemplateParameters['ADD_PREVIEW_THUMBNAIL'] = [
    'NAME' => Loc::getMessage('RS_B2B_CS_P_ADD_PREVIEW_THUMBNAIL'),
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];

if (
    !isset($arCurrentValues['ADD_PREVIEW_THUMBNAIL']) ||
    $arCurrentValues['ADD_PREVIEW_THUMBNAIL'] === 'Y'
)
{
    $arTemplateParameters['PREVIEW_THUMBNAIL_WIDTH'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('RS_B2B_CS_P_ADD_PREVIEW_THUMBNAIL_WIDTH'),
        'TYPE' => 'STRING',
        'DEFAULT' => 60
    ];

    $arTemplateParameters['PREVIEW_THUMBNAIL_HEIGHT'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::getMessage('RS_B2B_CS_P_ADD_PREVIEW_THUMBNAIL_HEIGHT'),
        'TYPE' => 'STRING',
        'DEFAULT' => 60
    ];
}

$arTemplateParameters['SHOW_VIEW_TEMPLATES'] = [
    'NAME' => Loc::getMessage('RS_B2B_CS_P_ADD_SHOW_VIEW_TEMPLATES'),
    'PARENT' => 'VISUAL',
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y',
    'REFRESH' => 'Y'
];