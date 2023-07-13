<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog;
use Bitrix\Iblock;


/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!Loader::includeModule('sale'))
    return;

$arThemes = array();
if ($eshop = \Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.eshop'))
{
    $arThemes['site'] = Loc::getMessage('THEME_SITE');
}
$arThemesList = array(
    'blue' => Loc::getMessage('THEME_BLUE'),
    'green' => Loc::getMessage('THEME_GREEN'),
    'red' => Loc::getMessage('THEME_RED'),
    'yellow' => Loc::getMessage('THEME_YELLOW')
);
$dir = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/css/main/themes/";
if (is_dir($dir))
{
    foreach ($arThemesList as $themeID => $themeName)
    {
        if (!is_file($dir . $themeID . '/style.css'))
            continue;
        $arThemes[$themeID] = $themeName;
    }
}

$arTemplateParameters = array(
    "TEMPLATE_THEME" => array(
        "NAME" => Loc::getMessage("TEMPLATE_THEME"),
        "TYPE" => "LIST",
        'VALUES' => $arThemes,
        'DEFAULT' => $eshop ? 'site' : 'blue',
        "PARENT" => "VISUAL"
    ),
    "SHOW_ORDER_BUTTON" => array(
        "NAME" => Loc::getMessage("SHOW_ORDER_BUTTON"),
        "TYPE" => "LIST",
        "VALUES" => array(
            'final_step' => Loc::getMessage("SHOW_FINAL_STEP"),
            'always' => Loc::getMessage("SHOW_ALWAYS")
        ),
        "PARENT" => "VISUAL",
    ),
    "SHOW_TOTAL_ORDER_BUTTON" => array(
        "NAME" => Loc::getMessage("SHOW_TOTAL_ORDER_BUTTON"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "PARENT" => "VISUAL",
    ),
    "SHOW_PAY_SYSTEM_LIST_NAMES" => array(
        "NAME" => Loc::getMessage("SHOW_PAY_SYSTEM_LIST_NAMES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_PAY_SYSTEM_INFO_NAME" => array(
        "NAME" => Loc::getMessage("SHOW_PAY_SYSTEM_INFO_NAME"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_DELIVERY_LIST_NAMES" => array(
        "NAME" => Loc::getMessage("SHOW_DELIVERY_LIST_NAMES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_DELIVERY_INFO_NAME" => array(
        "NAME" => Loc::getMessage("SHOW_DELIVERY_INFO_NAME"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_DELIVERY_PARENT_NAMES" => array(
        "NAME" => Loc::getMessage("DELIVERY_PARENT_NAMES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_STORES_IMAGES" => array(
        "NAME" => Loc::getMessage("SHOW_STORES_IMAGES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SKIP_USELESS_BLOCK" => array(
        "NAME" => Loc::getMessage("SKIP_USELESS_BLOCK"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "BASKET_POSITION" => array(
        "NAME" => Loc::getMessage("BASKET_POSITION"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => array(
            "after" => Loc::getMessage("BASKET_POSITION_AFTER"),
            "before" => Loc::getMessage("BASKET_POSITION_BEFORE")
        ),
        "DEFAULT" => "after",
        "PARENT" => "VISUAL"
    ),
    "SHOW_BASKET_HEADERS" => array(
        "NAME" => Loc::getMessage("SHOW_BASKET_HEADERS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "PARENT" => "VISUAL",
    ),
    "DELIVERY_FADE_EXTRA_SERVICES" => array(
        "NAME" => Loc::getMessage("DELIVERY_FADE_EXTRA_SERVICES"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "N",
        "PARENT" => "VISUAL",
    ),
    "SHOW_NEAREST_PICKUP" => array(
        "NAME" => Loc::getMessage("SHOW_NEAREST_PICKUP"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "N",
        "PARENT" => "VISUAL",
    ),
    "DELIVERIES_PER_PAGE" => array(
        "NAME" => Loc::getMessage("DELIVERIES_PER_PAGE"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => "9",
        "PARENT" => "VISUAL",
    ),
    "PAY_SYSTEMS_PER_PAGE" => array(
        "NAME" => Loc::getMessage("PAY_SYSTEMS_PER_PAGE"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => "9",
        "PARENT" => "VISUAL",
    ),
    "PICKUPS_PER_PAGE" => array(
        "NAME" => Loc::getMessage("PICKUPS_PER_PAGE"),
        "TYPE" => "STRING",
        "MULTIPLE" => "N",
        "DEFAULT" => "5",
        "PARENT" => "VISUAL",
    ),
    "SHOW_PICKUP_MAP" => array(
        "NAME" => Loc::getMessage("SHOW_PICKUP_MAP"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ),
    "SHOW_MAP_IN_PROPS" => array(
        "NAME" => Loc::getMessage("SHOW_MAP_IN_PROPS"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "N",
        "REFRESH" => "Y",
        "PARENT" => "VISUAL",
    ),
    "PICKUP_MAP_TYPE" => array(
        "NAME" => Loc::getMessage("PICKUP_MAP_TYPE"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => array(
            "yandex" => Loc::getMessage("PICKUP_MAP_TYPE_YANDEX"),
            "google" => Loc::getMessage("PICKUP_MAP_TYPE_GOOGLE")
        ),
        "DEFAULT" => "yandex",
        "PARENT" => "VISUAL"
    ),
    "SERVICES_IMAGES_SCALING" => array(
        "NAME" => Loc::getMessage("SERVICES_IMAGES_SCALING"),
        "TYPE" => "LIST",
        "VALUES" => array(
            'standard' => Loc::getMessage("SOA_STANDARD"),
            'adaptive' => Loc::getMessage("SOA_ADAPTIVE"),
            'no_scale' => Loc::getMessage("SOA_NO_SCALE")
        ),
        "DEFAULT" => "adaptive",
        "PARENT" => "ADDITIONAL_SETTINGS"
    ),
    "PRODUCT_COLUMNS_HIDDEN" => array(
        "NAME" => Loc::getMessage("PRODUCT_COLUMNS_HIDDEN"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "COLS" => 25,
        "SIZE" => 7,
        "VALUES" => array(),
        "DEFAULT" => array(),
        "ADDITIONAL_VALUES" => "N",
        "PARENT" => "ADDITIONAL_SETTINGS"
    ),
    "HIDE_ORDER_DESCRIPTION" => array(
        "NAME" => Loc::getMessage("HIDE_ORDER_DESCRIPTION"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "PARENT" => "ADDITIONAL_SETTINGS"
    ),
    "ALLOW_USER_PROFILES" => array(
        "NAME" => Loc::getMessage("ALLOW_USER_PROFILES"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "REFRESH" => "Y",
        "PARENT" => "BASE"
    ),
    "ALLOW_NEW_PROFILE" => array(
        "NAME" => Loc::getMessage("ALLOW_NEW_PROFILE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "HIDDEN" => $arCurrentValues['ALLOW_USER_PROFILES'] !== 'Y' ? 'Y' : 'N',
        "PARENT" => "BASE"
    ),
    "SHOW_COUPONS" => array(
        "NAME" => Loc::getMessage("SHOW_COUPONS"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "Y",
        "REFRESH" => "Y",
        "PARENT" => "VISUAL",
    ),
    "USE_YM_GOALS" => array(
        "NAME" => Loc::getMessage("USE_YM_GOALS1"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        "REFRESH" => "Y",
        "PARENT" => "ANALYTICS_SETTINGS"
    )
);

if (!isset($arCurrentValues['SHOW_COUPONS']) || $arCurrentValues['SHOW_COUPONS'] === 'Y')
{
    $arTemplateParameters["SHOW_COUPONS_BASKET"] = [
        "NAME" => Loc::getMessage("SHOW_COUPONS_BASKET"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ];
    $arTemplateParameters["SHOW_COUPONS_DELIVERY"] = [
        "NAME" => Loc::getMessage("SHOW_COUPONS_DELIVERY"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ];
    $arTemplateParameters["SHOW_COUPONS_PAY_SYSTEM"] = [
        "NAME" => Loc::getMessage("SHOW_COUPONS_PAY_SYSTEM"),
        "TYPE" => "CHECKBOX",
        "MULTIPLE" => "N",
        "DEFAULT" => "Y",
        "PARENT" => "VISUAL",
    ];
}

if ($arCurrentValues['USE_YM_GOALS'] == 'Y')
{
    $arTemplateParameters["YM_GOALS_COUNTER"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_COUNTER"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_INITIALIZE"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_INITIALIZE"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-order-init",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_REGION"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_REGION"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-region-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_DELIVERY"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_DELIVERY"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-delivery-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_PICKUP"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_PICKUP"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-pickUp-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_PAY_SYSTEM"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_PAY_SYSTEM"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-paySystem-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_PROPERTIES"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_PROPERTIES"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-properties-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_EDIT_BASKET"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_EDIT_BASKET"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-basket-edit",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_REGION"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_REGION"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-region-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_DELIVERY"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_DELIVERY"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-delivery-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_PICKUP"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_PICKUP"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-pickUp-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_PAY_SYSTEM"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_PAY_SYSTEM"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-paySystem-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_PROPERTIES"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_PROPERTIES"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-properties-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_NEXT_BASKET"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_NEXT_BASKET"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-basket-next",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
    $arTemplateParameters["YM_GOALS_SAVE_ORDER"] = array(
        "NAME" => Loc::getMessage("YM_GOALS_SAVE_ORDER"),
        "TYPE" => "STRING",
        "DEFAULT" => "BX-order-save",
        "PARENT" => "ANALYTICS_SETTINGS"
    );
}

$arTemplateParameters['USE_ENHANCED_ECOMMERCE'] = array(
    'PARENT' => 'ANALYTICS_SETTINGS',
    'NAME' => Loc::getMessage('USE_ENHANCED_ECOMMERCE'),
    'TYPE' => 'CHECKBOX',
    'REFRESH' => 'Y',
    'DEFAULT' => 'N'
);

if (isset($arCurrentValues['USE_ENHANCED_ECOMMERCE']) && $arCurrentValues['USE_ENHANCED_ECOMMERCE'] === 'Y')
{
    if (Loader::includeModule('catalog'))
    {
        $arIblockIDs = array();
        $arIblockNames = array();
        $catalogIterator = Catalog\CatalogIblockTable::getList(array(
            'select' => array('IBLOCK_ID', 'NAME' => 'IBLOCK.NAME'),
            'order' => array('IBLOCK_ID' => 'ASC')
        ));
        while ($catalog = $catalogIterator->fetch())
        {
            $catalog['IBLOCK_ID'] = (int)$catalog['IBLOCK_ID'];
            $arIblockIDs[] = $catalog['IBLOCK_ID'];
            $arIblockNames[$catalog['IBLOCK_ID']] = $catalog['NAME'];
        }
        unset($catalog, $catalogIterator);

        if (!empty($arIblockIDs))
        {
            $arProps = array();
            $propertyIterator = Iblock\PropertyTable::getList(array(
                'select' => array('ID', 'CODE', 'NAME', 'IBLOCK_ID'),
                'filter' => array('@IBLOCK_ID' => $arIblockIDs, '=ACTIVE' => 'Y', '!=XML_ID' => CIBlockPropertyTools::XML_SKU_LINK),
                'order' => array('IBLOCK_ID' => 'ASC', 'SORT' => 'ASC', 'ID' => 'ASC')
            ));
            while ($property = $propertyIterator->fetch())
            {
                $property['ID'] = (int)$property['ID'];
                $property['IBLOCK_ID'] = (int)$property['IBLOCK_ID'];
                $property['CODE'] = (string)$property['CODE'];

                if ($property['CODE'] == '')
                {
                    $property['CODE'] = $property['ID'];
                }

                if (!isset($arProps[$property['CODE']]))
                {
                    $arProps[$property['CODE']] = array(
                        'CODE' => $property['CODE'],
                        'TITLE' => $property['NAME'] . ' [' . $property['CODE'] . ']',
                        'ID' => array($property['ID']),
                        'IBLOCK_ID' => array($property['IBLOCK_ID'] => $property['IBLOCK_ID']),
                        'IBLOCK_TITLE' => array($property['IBLOCK_ID'] => $arIblockNames[$property['IBLOCK_ID']]),
                        'COUNT' => 1
                    );
                }
                else
                {
                    $arProps[$property['CODE']]['ID'][] = $property['ID'];
                    $arProps[$property['CODE']]['IBLOCK_ID'][$property['IBLOCK_ID']] = $property['IBLOCK_ID'];

                    if ($arProps[$property['CODE']]['COUNT'] < 2)
                    {
                        $arProps[$property['CODE']]['IBLOCK_TITLE'][$property['IBLOCK_ID']] = $arIblockNames[$property['IBLOCK_ID']];
                    }

                    $arProps[$property['CODE']]['COUNT']++;
                }
            }
            unset($property, $propertyIterator, $arIblockNames, $arIblockIDs);

            $propList = array();
            foreach ($arProps as $property)
            {
                $iblockList = '';

                if ($property['COUNT'] > 1)
                {
                    $iblockList = ($property['COUNT'] > 2 ? ' ( ... )' : ' (' . implode(', ', $property['IBLOCK_TITLE']) . ')');
                }

                $propList['PROPERTY_' . $property['CODE']] = $property['TITLE'] . $iblockList;
            }
            unset($property, $arProps);
        }
    }

    $arTemplateParameters['DATA_LAYER_NAME'] = array(
        'PARENT' => 'ANALYTICS_SETTINGS',
        'NAME' => Loc::getMessage('DATA_LAYER_NAME'),
        'TYPE' => 'STRING',
        'DEFAULT' => 'dataLayer'
    );

    if (!empty($propList))
    {
        $arTemplateParameters['BRAND_PROPERTY'] = array(
            'PARENT' => 'ANALYTICS_SETTINGS',
            'NAME' => Loc::getMessage('BRAND_PROPERTY'),
            'TYPE' => 'LIST',
            'MULTIPLE' => 'N',
            'DEFAULT' => '',
            'VALUES' => array('' => '') + $propList
        );
    }
}

if ($arCurrentValues['SHOW_MAP_IN_PROPS'] == 'Y')
{
    $arDelivery = array();
    $services = Bitrix\Sale\Delivery\Services\Manager::getActiveList();
    foreach ($services as $service)
    {
        $arDelivery[$service['ID']] = $service['NAME'];
    }

    $arTemplateParameters["SHOW_MAP_FOR_DELIVERIES"] = array(
        "NAME" => Loc::getMessage("SHOW_MAP_FOR_DELIVERIES"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $arDelivery,
        "DEFAULT" => "",
        "COLS" => 25,
        "ADDITIONAL_VALUES" => "N",
        "PARENT" => "VISUAL"
    );
}

$dbPerson = CSalePersonType::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array('ACTIVE' => 'Y'));
while ($arPerson = $dbPerson->GetNext())
{
    $arPers2Prop = array();

    $dbProp = CSaleOrderProps::GetList(
        array("SORT" => "ASC", "NAME" => "ASC"),
        array("PERSON_TYPE_ID" => $arPerson["ID"], 'UTIL' => 'N')
    );
    while ($arProp = $dbProp->Fetch())
    {
        if ($arProp["IS_LOCATION"] == 'Y')
        {
            if (intval($arProp["INPUT_FIELD_LOCATION"]) > 0)
                $altPropId = $arProp["INPUT_FIELD_LOCATION"];

            continue;
        }

        $arPers2Prop[$arProp["ID"]] = $arProp["NAME"];
    }

    if (isset($altPropId))
        unset($arPers2Prop[$altPropId]);

    if (!empty($arPers2Prop))
    {
        $arTemplateParameters["PROPS_FADE_LIST_" . $arPerson["ID"]] = array(
            "NAME" => Loc::getMessage("PROPS_FADE_LIST") . ' (' . $arPerson["NAME"] . ')' . '[' . $arPerson["LID"] . ']',
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arPers2Prop,
            "DEFAULT" => "",
            "COLS" => 25,
            "ADDITIONAL_VALUES" => "N",
            "PARENT" => "VISUAL"
        );
    }
}
unset($arPerson, $dbPerson);

$arTemplateParameters["USE_CUSTOM_MAIN_MESSAGES"] = array(
    "NAME" => Loc::getMessage("USE_CUSTOM_MESSAGES"),
    "TYPE" => "CHECKBOX",
    "REFRESH" => 'Y',
    "DEFAULT" => 'N',
    "PARENT" => "MAIN_MESSAGE_SETTINGS"
);

if ($arCurrentValues['USE_CUSTOM_MAIN_MESSAGES'] == 'Y')
{
    $arTemplateParameters["MESS_AUTH_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("AUTH_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("AUTH_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_REG_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("REG_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("REG_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_BASKET_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("BASKET_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("BASKET_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_REGION_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("REGION_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("REGION_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PAYMENT_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("PAYMENT_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PAYMENT_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_DELIVERY_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("DELIVERY_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("DELIVERY_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_BUYER_BLOCK_NAME"] = array(
        "NAME" => Loc::getMessage("BUYER_BLOCK_NAME"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("BUYER_BLOCK_NAME_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_BACK"] = array(
        "NAME" => Loc::getMessage("BACK"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("BACK_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_FURTHER"] = array(
        "NAME" => Loc::getMessage("FURTHER"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("FURTHER_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_EDIT"] = array(
        "NAME" => Loc::getMessage("EDIT"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("EDIT_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_ORDER"] = array(
        "NAME" => Loc::getMessage("ORDER"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("ORDER_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PRICE"] = array(
        "NAME" => Loc::getMessage("PRICE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PRICE_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PERIOD"] = array(
        "NAME" => Loc::getMessage("PERIOD"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PERIOD_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_NAV_BACK"] = array(
        "NAME" => Loc::getMessage("NAV_BACK"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("NAV_BACK_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_NAV_FORWARD"] = array(
        "NAME" => Loc::getMessage("NAV_FORWARD"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("NAV_FORWARD_DEFAULT"),
        "PARENT" => "MAIN_MESSAGE_SETTINGS"
    );
}

$arTemplateParameters["USE_CUSTOM_ADDITIONAL_MESSAGES"] = array(
    "NAME" => Loc::getMessage("USE_CUSTOM_MESSAGES"),
    "TYPE" => "CHECKBOX",
    "REFRESH" => 'Y',
    "DEFAULT" => 'N',
    "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
);

if ($arCurrentValues['USE_CUSTOM_ADDITIONAL_MESSAGES'] == 'Y')
{
    $arTemplateParameters["MESS_PRICE_FREE"] = array(
        "NAME" => Loc::getMessage("PRICE_FREE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PRICE_FREE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_ECONOMY"] = array(
        "NAME" => Loc::getMessage("ECONOMY"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("ECONOMY_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_REGISTRATION_REFERENCE"] = array(
        "NAME" => Loc::getMessage("REGISTRATION_REFERENCE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("REGISTRATION_REFERENCE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_AUTH_REFERENCE_1"] = array(
        "NAME" => Loc::getMessage("AUTH_REFERENCE_1"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("AUTH_REFERENCE_1_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_AUTH_REFERENCE_2"] = array(
        "NAME" => Loc::getMessage("AUTH_REFERENCE_2"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("AUTH_REFERENCE_2_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_AUTH_REFERENCE_3"] = array(
        "NAME" => Loc::getMessage("AUTH_REFERENCE_3"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("AUTH_REFERENCE_3_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_ADDITIONAL_PROPS"] = array(
        "NAME" => Loc::getMessage("ADDITIONAL_PROPS"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("ADDITIONAL_PROPS_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_USE_COUPON"] = array(
        "NAME" => Loc::getMessage("USE_COUPON"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("USE_COUPON_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_COUPON"] = array(
        "NAME" => Loc::getMessage("COUPON"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("COUPON_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PERSON_TYPE"] = array(
        "NAME" => Loc::getMessage("PERSON_TYPE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PERSON_TYPE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_SELECT_PROFILE"] = array(
        "NAME" => Loc::getMessage("SELECT_PROFILE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("SELECT_PROFILE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_REGION_REFERENCE"] = array(
        "NAME" => Loc::getMessage("REGION_REFERENCE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("REGION_REFERENCE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PICKUP_LIST"] = array(
        "NAME" => Loc::getMessage("PICKUP_LIST"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PICKUP_LIST_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_NEAREST_PICKUP_LIST"] = array(
        "NAME" => Loc::getMessage("NEAREST_PICKUP_LIST"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("NEAREST_PICKUP_LIST_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_SELECT_PICKUP"] = array(
        "NAME" => Loc::getMessage("SELECT_PICKUP"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("SELECT_PICKUP_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_INNER_PS_BALANCE"] = array(
        "NAME" => Loc::getMessage("INNER_PS_BALANCE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("INNER_PS_BALANCE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_INNER_PS_BALANCE"] = array(
        "NAME" => Loc::getMessage("INNER_PS_BALANCE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("INNER_PS_BALANCE_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_ORDER_DESC"] = array(
        "NAME" => Loc::getMessage("ORDER_DESC"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("ORDER_DESC_DEFAULT"),
        "PARENT" => "ADDITIONAL_MESSAGE_SETTINGS"
    );
}

$arTemplateParameters["USE_CUSTOM_ERROR_MESSAGES"] = array(
    "NAME" => Loc::getMessage("USE_CUSTOM_MESSAGES"),
    "TYPE" => "CHECKBOX",
    "REFRESH" => 'Y',
    "DEFAULT" => 'N',
    "PARENT" => "ERROR_MESSAGE_SETTINGS"
);

if ($arCurrentValues['USE_CUSTOM_ERROR_MESSAGES'] == 'Y')
{
    $arTemplateParameters["MESS_SUCCESS_PRELOAD_TEXT"] = array(
        "NAME" => Loc::getMessage("SUCCESS_PRELOAD_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("SUCCESS_PRELOAD_TEXT_DEFAULT"),
        "PARENT" => "ERROR_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_FAIL_PRELOAD_TEXT"] = array(
        "NAME" => Loc::getMessage("FAIL_PRELOAD_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("FAIL_PRELOAD_TEXT_DEFAULT"),
        "PARENT" => "ERROR_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_DELIVERY_CALC_ERROR_TITLE"] = array(
        "NAME" => Loc::getMessage("DELIVERY_CALC_ERROR_TITLE"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("DELIVERY_CALC_ERROR_TITLE_DEFAULT"),
        "PARENT" => "ERROR_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_DELIVERY_CALC_ERROR_TEXT"] = array(
        "NAME" => Loc::getMessage("DELIVERY_CALC_ERROR_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("DELIVERY_CALC_ERROR_TEXT_DEFAULT"),
        "PARENT" => "ERROR_MESSAGE_SETTINGS"
    );
    $arTemplateParameters["MESS_PAY_SYSTEM_PAYABLE_ERROR"] = array(
        "NAME" => Loc::getMessage("PAY_SYSTEM_PAYABLE_ERROR_TEXT"),
        "TYPE" => "STRING",
        "DEFAULT" => Loc::getMessage("PAY_SYSTEM_PAYABLE_ERROR_DEFAULT"),
        "PARENT" => "ERROR_MESSAGE_SETTINGS"
    );
}
