<?php

use Redsign\B2BPortal\Iblock\PropertyFeature;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}


$PREVIEW_WIDTH = intval($arParams["PREVIEW_WIDTH"]);
if ($PREVIEW_WIDTH <= 0) {
    $PREVIEW_WIDTH = 75;
}

$PREVIEW_HEIGHT = intval($arParams["PREVIEW_HEIGHT"]);
if ($PREVIEW_HEIGHT <= 0) {
    $PREVIEW_HEIGHT = 75;
}

$arParams["PRICE_VAT_INCLUDE"] = $arParams["PRICE_VAT_INCLUDE"] !== "N";

$arCatalogs = false;

$arResult["ELEMENTS"] = array();
$arResult["SEARCH"] = array();
foreach ($arResult["CATEGORIES"] as $category_id => $arCategory) {
    foreach ($arCategory["ITEMS"] as $i => $arItem) {
        if (isset($arItem["ITEM_ID"])) {
            $arResult["SEARCH"][] = &$arResult["CATEGORIES"][$category_id]["ITEMS"][$i];
            if (
                $arItem["MODULE_ID"] == "iblock"
                && mb_substr($arItem["ITEM_ID"], 0, 1) !== "S"
            ) {
                if ($arCatalogs === false) {
                    $arCatalogs = array();
                    if (CModule::IncludeModule("catalog")) {
                        $rsCatalog = CCatalog::GetList(array(
                            "sort" => "asc",
                        ));
                        while ($ar = $rsCatalog->Fetch()) {
                            if ($ar["PRODUCT_IBLOCK_ID"]) {
                                $arCatalogs[$ar["PRODUCT_IBLOCK_ID"]] = 1;
                            } else {
                                $arCatalogs[$ar["IBLOCK_ID"]] = 1;
                            }
                        }
                    }
                }

                if (array_key_exists($arItem["PARAM2"], $arCatalogs)) {
                    $arResult["ELEMENTS"][$arItem["ITEM_ID"]] = $arItem["ITEM_ID"];
                }
            }
        }
    }
}

$arResult['ARTICLE_PROP_CODES'] = [];
if ($arCatalogs) {
    if (PropertyFeature::isEnabledFeatures()) {
        $iblocks = array_keys($arCatalogs);
        foreach ($iblocks as $iblockId) {
            $arResult["ARTICLE_PROP_CODES"][$iblockId] = PropertyFeature::getFirstArticlePropertyCode(
                (int)$iblockId,
                ["CODE" => "Y"]
            );
        }

        unset($iblocks, $iblockId);
    } else {
        $iblocks = array_keys($arCatalogs);
        foreach ($iblocks as $iblockId) {
            $arResult['ARTICLE_PROP_CODES'][$iblockId] = $arParams['PROP_CODE_ARTICLE'];
        }

        unset($iblocks, $iblockId);
    }
}

if (!empty($arResult["ELEMENTS"]) && CModule::IncludeModule("iblock")) {
    $arConvertParams = array();
    if ('Y' == $arParams['CONVERT_CURRENCY']) {
        if (!CModule::IncludeModule('currency')) {
            $arParams['CONVERT_CURRENCY'] = 'N';
            $arParams['CURRENCY_ID'] = '';
        } else {
            $arCurrencyInfo = CCurrency::GetByID($arParams['CURRENCY_ID']);
            if (!(is_array($arCurrencyInfo) && !empty($arCurrencyInfo))) {
                $arParams['CONVERT_CURRENCY'] = 'N';
                $arParams['CURRENCY_ID'] = '';
            } else {
                $arParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
                $arConvertParams['CURRENCY_ID'] = $arCurrencyInfo['CURRENCY'];
            }
        }
    }

    $useCatalogTab = (string)\Bitrix\Main\Config\Option::get('catalog', 'show_catalog_tab_with_offers') == 'Y';

    $obParser = new CTextParser();

    if (is_array($arParams["PRICE_CODE"])) {
        $arResult["PRICES"] = CIBlockPriceTools::GetCatalogPrices(0, $arParams["PRICE_CODE"]);
    } else {
        $arResult["PRICES"] = array();
    }

    $arSelect = array(
        "ID",
        "TYPE",
        "NAME",
        "IBLOCK_ID",
        "PREVIEW_TEXT",
        "PREVIEW_PICTURE",
        "DETAIL_PICTURE",
        "AVAILABLE",
        "CAN_BUY_ZERO"
    );

    foreach ($arResult["ARTICLE_PROP_CODES"] as $propCode) {
        if ($propCode && !in_array($propCode, $arSelect)) {
            $arSelect[] = 'PROPERTY_' . $propCode;
        }
    }
    unset($propCode);

    $arFilter = array(
        "IBLOCK_LID" => SITE_ID,
        "IBLOCK_ACTIVE" => "Y",
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y",
        "MIN_PERMISSION" => "R",
    );
    foreach ($arResult["PRICES"] as $value) {
        if (!$value['CAN_VIEW'] && !$value['CAN_BUY']) {
            continue;
        }
        $arSelect[] = $value["SELECT"];
        $arFilter["CATALOG_SHOP_QUANTITY_" . $value["ID"]] = 1;
    }
    $arFilter["=ID"] = $arResult["ELEMENTS"];
    $arResult["ELEMENTS"] = array();
    $rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    while ($arElement = $rsElements->Fetch()) {
        $arElement["PRICES"] = array();
        $arElement["PRICES"] = CIBlockPriceTools::GetItemPrices(
            $arElement["IBLOCK_ID"],
            $arResult["PRICES"],
            $arElement,
            $arParams['PRICE_VAT_INCLUDE'],
            $arConvertParams
        );
        $arElement['MIN_PRICE'] = CIBlockPriceTools::getMinPriceFromList($arElement['PRICES']);

        if ($arParams["PREVIEW_TRUNCATE_LEN"] > 0) {
            $arElement["PREVIEW_TEXT"] = $obParser->html_cut(
                $arElement["PREVIEW_TEXT"],
                $arParams["PREVIEW_TRUNCATE_LEN"]
            );
        }

        $arResult["ELEMENTS"][$arElement["ID"]] = $arElement;
    }
}

foreach ($arResult["SEARCH"] as $i => $arItem) {
    switch ($arItem["MODULE_ID"]) {
        case "iblock":
            if (array_key_exists($arItem["ITEM_ID"], $arResult["ELEMENTS"])) {
                $arElement = &$arResult["ELEMENTS"][$arItem["ITEM_ID"]];

                if ($arParams["SHOW_PREVIEW"] == "Y") {
                    if ($arElement["PREVIEW_PICTURE"] > 0) {
                        $arElement["PICTURE"] = CFile::ResizeImageGet(
                            $arElement["PREVIEW_PICTURE"],
                            array("width" => $PREVIEW_WIDTH, "height" => $PREVIEW_HEIGHT),
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            true
                        );
                    } elseif ($arElement["DETAIL_PICTURE"] > 0) {
                        $arElement["PICTURE"] = CFile::ResizeImageGet(
                            $arElement["DETAIL_PICTURE"],
                            array("width" => $PREVIEW_WIDTH, "height" => $PREVIEW_HEIGHT),
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            true
                        );
                    }
                }
            }
            break;
    }

    $arResult["SEARCH"][$i]["ICON"] = true;
}


if (!$arResult["ELEMENTS"]) {
    $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL");
    $arFilter = array(
        "IBLOCK_ID" => IntVal(5),
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "NAME" => "%" . $arResult["query"] . "%"
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 5), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arResult['SEARCH'][] = [
            "NAME" => str_replace($arResult["query"], "<b>" . $arResult["query"] . "</b>", $arFields['NAME']),
            "URL" => $arFields['DETAIL_PAGE_URL'],
            "MODULE_ID" => "iblock",
            "PARAM1" => "catalog",
            "PARAM2" => "5",
            "ITEM_ID" => $arFields['ID'],
            "ICON" => "1",
        ];

        $ar_res = CCatalogProduct::GetByIDEx($arFields['ID']);




        $pic = CFile::GetPath($ar_res["DETAIL_PICTURE"]);
        $price = null;

        foreach ($ar_res['PRICES'] as $key => $item){
            if($item['CURRENCY'] == "RUB"){
                $price = $item;
                $price['ID'] = $key;
            }
        }


        $arResult['ELEMENTS'][$arFields['ID']] = array
        (
            "ID" => $ar_res['ID'],
            "NAME" => $ar_res['NAME'],
            "IBLOCK_ID" => $ar_res['IBLOCK_ID'],
            "PREVIEW_TEXT" => $ar_res['PREVIEW_TEXT'],
            "PREVIEW_PICTURE" => $ar_res['PREVIEW_PICTURE'],
            "DETAIL_PICTURE" => $ar_res['DETAIL_PICTURE'],
            "PROPERTY_CML2_ARTICLE_VALUE" => $ar_res['PROPERTIES']['CML2_ARTICLE']['VALUE'],
            "PROPERTY_CML2_ARTICLE_VALUE_ID" => null,
            "PREVIEW_TEXT_TYPE" => $ar_res['PREVIEW_TEXT_TYPE'],
            "TYPE" =>  $ar_res['PRODUCT']["TYPE"],
            "AVAILABLE" => $ar_res['PRODUCT']["AVAILABLE"],
            "CAN_BUY_ZERO" => $ar_res['PRODUCT']["CAN_BUY_ZERO"],
            "CATALOG_PRICE_ID_1" => null,
            "CATALOG_GROUP_ID_1" => "",
            "CATALOG_PRICE_1" => null,
            "CATALOG_CURRENCY_1" => null,
            "CATALOG_QUANTITY_FROM_1" => null,
            "CATALOG_QUANTITY_TO_1" => null,
            "CATALOG_EXTRA_ID_1" => null,
            "CATALOG_GROUP_NAME_1" => "Цена",
            "CATALOG_CAN_ACCESS_1" => "Y",
            "CATALOG_CAN_BUY_1" => "Y",
            "CATALOG_QUANTITY" => $ar_res['PRODUCT']['QUANTITY'],
            "CATALOG_QUANTITY_TRACE" => $ar_res['PRODUCT']['QUANTITY_TRACE'],
            "CATALOG_QUANTITY_TRACE_ORIG" => $ar_res['PRODUCT']['QUANTITY_TRACE_ORIG'],
            "CATALOG_WEIGHT" => $ar_res['PRODUCT']['WEIGHT'],
            "CATALOG_VAT_ID" => $ar_res['PRODUCT']['VAT_ID'],
            "CATALOG_VAT_INCLUDED" => $ar_res['PRODUCT']['VAT_INCLUDED'],
            "CATALOG_CAN_BUY_ZERO" => $ar_res['PRODUCT']['CAN_BUY_ZERO'],
            "CATALOG_CAN_BUY_ZERO_ORIG" => $ar_res['PRODUCT']['CAN_BUY_ZERO_ORIG'],
            "CATALOG_PURCHASING_PRICE" => $ar_res['PRODUCT']['PURCHASING_PRICE'],
            "CATALOG_PURCHASING_CURRENCY" => $ar_res['PRODUCT']['PURCHASING_CURRENCY'],
            "CATALOG_QUANTITY_RESERVED" => $ar_res['PRODUCT']['QUANTITY_RESERVED'],
            "CATALOG_SUBSCRIBE" => $ar_res['PRODUCT']['SUBSCRIBE'],
            "CATALOG_SUBSCRIBE_ORIG" => $ar_res['PRODUCT']['SUBSCRIBE_ORIG'],
            "CATALOG_WIDTH" => $ar_res['PRODUCT']['WIDTH'],
            "CATALOG_LENGTH" => $ar_res['PRODUCT']['LENGTH'],
            "CATALOG_HEIGHT" => $ar_res['PRODUCT']['HEIGHT'],
            "CATALOG_MEASURE" => $ar_res['PRODUCT']['MEASURE'],
            "CATALOG_TYPE" => $ar_res['PRODUCT']['TYPE'],
            "CATALOG_AVAILABLE" => $ar_res['PRODUCT']['AVAILABLE'],
            "CATALOG_BUNDLE" => $ar_res['PRODUCT']['BUNDLE'],
            "CATALOG_PRICE_TYPE" => $ar_res['PRODUCT']['PRICE_TYPE'],
            "CATALOG_RECUR_SCHEME_LENGTH" => $ar_res['PRODUCT']['RECUR_SCHEME_LENGTH'],
            "CATALOG_RECUR_SCHEME_TYPE" => $ar_res['PRODUCT']['RECUR_SCHEME_TYPE'],
            "CATALOG_TRIAL_PRICE_ID" => $ar_res['PRODUCT']['TRIAL_PRICE_ID'],
            "CATALOG_WITHOUT_ORDER" => $ar_res['PRODUCT']['WITHOUT_ORDER'],
            "CATALOG_SELECT_BEST_PRICE" => $ar_res['PRODUCT']['SELECT_BEST_PRICE'],
            "CATALOG_NEGATIVE_AMOUNT_TRACE" => $ar_res['PRODUCT']['NEGATIVE_AMOUNT_TRACE'],
            "CATALOG_NEGATIVE_AMOUNT_TRACE_ORIG" => $ar_res['PRODUCT']['NEGATIVE_AMOUNT_TRACE_ORIG'],
            "CATALOG_VAT" => null,
            "PRICES" => array(),
            "MIN_PRICE" => null,
            "PICTURE" => array(
                "src" => $pic,
                "width" => 75,
                "height" => 75,
                "size" => 1582,
            )
        );

        $arResult['CATEGORIES'][0]["TITLE"] = "Каталог";
        $arResult['CATEGORIES'][0]["ITEMS"][] = [
            "NAME" => str_replace($arResult["query"], "<b>" . $arResult["query"] . "</b>", $arFields['NAME']),
            "URL" => $arFields['DETAIL_PAGE_URL'],
            "MODULE_ID" => "iblock",
            "PARAM1" => "catalog",
            "PARAM2" => "5",
            "ITEM_ID" => $arFields['ID'],
            "ICON" => "1",
        ];
    }
}









