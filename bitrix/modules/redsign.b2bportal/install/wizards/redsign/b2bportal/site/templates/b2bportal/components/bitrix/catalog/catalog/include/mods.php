<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CCacheManager $CACHE_MANAGER
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var int $elementId
 * @var string $basketAction
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (intval($elementId) < 1)
	return;

$arFilter = array(
	'IBLOCK_ID' => $arParams['IBLOCK_ID'],
);
$obCache = new \CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), '/iblock/catalog'))
{
	$arCurIBlock = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
	$arCurIBlock = \CIBlockPriceTools::GetOffersIBlock($arParams['IBLOCK_ID']);
	if (defined('BX_COMP_MANAGED_CACHE'))
	{
		global $CACHE_MANAGER;
		$CACHE_MANAGER->StartTagCache('/iblock/catalog');
		if ($arCurIBlock)
		{
			$CACHE_MANAGER->RegisterTag('iblock_id_' . $arParams['IBLOCK_ID']);
		}
		$CACHE_MANAGER->EndTagCache();
	}
	else
	{
		if (!$arCurIBlock)
		{
			$arCurIBlock = [];
		}
	}
	$obCache->EndDataCache($arCurIBlock);
}

if (!isset($arCurIBlock))
	$arCurIBlock = [];

global $modFilter;

$flag = \CCatalogSku::getExistOffers($elementId, $arParams['IBLOCK_ID']);
if ($flag[$elementId])
{
	$iblockId = $arCurIBlock['OFFERS_IBLOCK_ID'];
	$modFilter = [
		'PROPERTY_' . $arCurIBlock['OFFERS_PROPERTY_ID'] => $elementId,
	];
	$blockTitle = Loc::getMessage('RS.B2BPORTAL.CATALOG_ELEMENT.PRODUCT_LIST.BLOCK_TITLE');

	$enablePreviewPicture = isset($arParams['LIST_ENABLE_PREVIEW_PICTURE']) ? $arParams['LIST_ENABLE_PREVIEW_PICTURE'] : 'N';
	$previewPictureSwitcher = isset($arParams['LIST_PREVIEW_PICTURE_SWITCHER']) ? $arParams['LIST_PREVIEW_PICTURE_SWITCHER'] : 'N';
}
else
{
	$iblockId = $arParams['IBLOCK_ID'];
	$modFilter = [
		'ID' => $elementId,
	];
	$blockTitle = '';

	$enablePreviewPicture = 'N';
	$previewPictureSwitcher = 'N';
}

$componentSectionParams = [
	'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
	'IBLOCK_ID' => $iblockId,
	"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
	"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
	"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
	"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
	"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
	"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
	"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
	"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
	"BASKET_URL" => $arParams["BASKET_URL"],
	"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
	"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
	"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
	"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
	"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
	"FILTER_NAME" => "modFilter",
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_FILTER" => $arParams["CACHE_FILTER"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"SET_TITLE" => 'N',
	"MESSAGE_404" => '',
	"SET_STATUS_404" => 'N',
	"SHOW_404" => 'N',
	"FILE_404" => '',
	"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
	"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
	"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
	"PRICE_CODE" => $arParams["PRICE_CODE"],
	"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
	"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

	"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
	"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
	"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
	"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

	"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
	"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
	"PAGER_TITLE" => $arParams["PAGER_TITLE"],
	"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
	"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
	"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
	"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
	"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
	"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
	"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
	"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
	"LAZY_LOAD" => $arParams["LAZY_LOAD"],
	"MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
	"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

	"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
	"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
	"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
	"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
	"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
	"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
	"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
	"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"SECTION_URL" => '',
	"DETAIL_URL" => '',
	"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
	'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
	'CURRENCY_ID' => $arParams['CURRENCY_ID'],
	'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
	'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

	'LABEL_PROP' => [],
	'LABEL_PROP_MOBILE' => [],
	'LABEL_PROP_POSITION' => $arParams['LIST_LABEL_PROP_POSITION'],
	'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
	'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
	'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
	'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
	'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
	'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
	'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

	'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
	'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
	'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
	'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
	'MAX_QUANTITY' => $arParams['MAX_QUANTITY'] ?? null,
	'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
	'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
	'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
	'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
	'MESS_BTN_ADD_TO_BASKET' => isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : '',
	'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
	'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
	'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
	'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

	'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
	'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
	'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

	'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
	"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
	'ADD_TO_BASKET_ACTION' => $basketAction,
	'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
	'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
	'COMPARE_NAME' => $arParams['COMPARE_NAME'],
	'USE_COMPARE_LIST' => 'Y',
	'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
	'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
	'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),

	// 'SITE_LOCATION_ID' => SITE_LOCATION_ID,
	"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
	"FILL_ITEM_ALL_PRICES" => (is_array($arParams['PRICE_CODE']) && count($arParams['PRICE_CODE']) > 1) ? 'Y' : $arParams['FILL_ITEM_ALL_PRICES'],

	'SHOW_ARTNUMBER' => $arParams['SHOW_ARTNUMBER'],
	'ARTNUMBER_PROP' => $arParams['ARTNUMBER_PROP'],
	'OFFER_ARTNUMBER_PROP' => $arParams['OFFER_ARTNUMBER_PROP'],
	'FIELD_CODE' => $arParams['LIST_FIELD_CODE'],

	'SECTION_ADD_TO_BASKET_ACTION' => $arParams['SECTION_ADD_TO_BASKET_ACTION'],

	'BY_LINK' => 'Y',
	// 'ALLOW_WO_SECTION' => 'Y',

	'HIDE_DETAIL_LINKS' => 'Y',
	'HIDE_HEAD' => (empty($blockTitle) ? 'Y' : 'N'),
	'HIDE_FOOT' => 'Y',
	'RETURN_IF_EMPTY' => 'Y',
	'BLOCK_TITLE' => $blockTitle,
	'PROP_CODE_ARTICLE' => $arParams['OFFERS_PROP_CODE_ARTICLE'],
	'ENABLE_PREVIEW_PICTURE' => $enablePreviewPicture,
	'PREVIEW_PICTURE_SWITCHER' => $previewPictureSwitcher,
	'USE_STORE' => $arParams['USE_STORE'],
	'STORES' => $arParams['STORES'],
	'ADD_PREVIEW_THUMBNAIL' => $arParams['LIST_ADD_PREVIEW_THUMBNAIL'],
	'PREVIEW_THUMBNAIL_WIDTH' => $arParams['LIST_PREVIEW_THUMBNAIL_WIDTH'],
	'PREVIEW_THUMBNAIL_HEIGHT' => $arParams['LIST_PREVIEW_THUMBNAIL_HEIGHT'],

	'STORAGE_PREFIX' => 'catalog_mods',
];

$componentSorterParams = [
	'SORT_FIELDS' => $arParams['SORT_FIELDS'],
	'SORT_DEFAULT_FIELD' => $arParams['SORT_DEFAULT_FIELD'],
	'SORT_DEFAULT_ORDER' => $arParams['SORT_DEFAULT_ORDER'],
	'PERPAGE_FIELDS' => $arParams['PERPAGE_FIELDS'],
	'PERPAGE_DEFAULT' => $arParams['PERPAGE_DEFAULT'],
];

$componentSectionParams = array_merge($componentSectionParams, $componentSorterParams);

// $componentSectionParams['PROPERTY_CODE'] = array_merge($arParams['LIST_PROPERTY_CODE'], $arParams['PROP_CODE_MODIFICATIONS']);
$componentSectionParams['PROPERTY_CODE'] = array_filter($arParams['LIST_OFFERS_PROPERTY_CODE']);
?>

<!-- begin: modifications -->
<?$APPLICATION->IncludeComponent(
	'redsign:b2bportal.catalog.section',
	'',
	$componentSectionParams,
	$component
);?>
<!-- end: modifications -->
