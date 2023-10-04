<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\DI;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

$APPLICATION->SetTitle(Loc::getMessage('SEARCH_PAGE_TITLE'));
$APPLICATION->AddChainItem(Loc::getMessage('SEARCH_PAGE_TITLE'), $APPLICATION->GetCurPage());

if (isset($arParams['FILTER_ENABLE_HIDE_NOT_AVAILABLE']) && $arParams['FILTER_ENABLE_HIDE_NOT_AVAILABLE'] == 'Y')
{
	/** @var \Bitrix\Main\HttpRequest */
	$request = DI\ServiceContainer::getInstance()->get('Request');
	if ($request->get('hide_not_available'))
	{
		$arParams['HIDE_NOT_AVAILABLE'] = $arParams['HIDE_NOT_AVAILABLE_OFFERS'] = $request->get('hide_not_available');
	}
}

global $searchFilter;
$notFound = false;

if (Loader::includeModule('search'))
{
	$this->SetViewTarget('catalog_search');
		$arElements = $APPLICATION->IncludeComponent(
			"bitrix:search.page",
			"catalog",
			[
				"RESTART" => $arParams["RESTART"],
				"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
				"USE_LANGUAGE_GUESS" => 'N',
				"CHECK_DATES" => $arParams["CHECK_DATES"],
				"arrFILTER" => ["iblock_" . $arParams["IBLOCK_TYPE"]],
				"arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => [$arParams["IBLOCK_ID"]],
				"USE_TITLE_RANK" => "N",
				"DEFAULT_SORT" => "rank",
				"FILTER_NAME" => "",
				"SHOW_WHERE" => "N",
				"arrWHERE" => [],
				"SHOW_WHEN" => "N",
				"PAGE_RESULT_COUNT" => ($arParams["PAGE_RESULT_COUNT"] ?? 50),
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "N",
			],
			$component,
			['HIDE_ICONS' => 'Y']
		);
	$this->EndViewTarget();

	if (!empty($arElements) && is_array($arElements))
	{
		$searchFilter = [
			"ID" => $arElements,
		];
	}
	else
	{
		$notFound = true;
		$searchFilter = [
			"=ID" => -1,
		];
	}
}
else
{
	$searchQuery = '';
	if (isset($_REQUEST['q']) && is_string($_REQUEST['q']))
	{
		$searchQuery = trim($_REQUEST['q']);
	}

	if ($searchQuery !== '')
	{
		$searchFilter = [
			'*SEARCHABLE_CONTENT' => $searchQuery
		];
	}
	unset($searchQuery);
}

$componentSectionParams = [
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
	"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
	"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
	"PROPERTY_CODE_MOBILE" => ($arParams["LIST_PROPERTY_CODE_MOBILE"] ?? []),
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
	"FILTER_NAME" => $arParams['FILTER_NAME'],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_FILTER" => $arParams["CACHE_FILTER"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"SET_TITLE" => $arParams["SET_TITLE"],
	"MESSAGE_404" => $arParams["~MESSAGE_404"],
	"SET_STATUS_404" => $arParams["SET_STATUS_404"],
	"SHOW_404" => $arParams["SHOW_404"],
	"FILE_404" => $arParams["FILE_404"],
	"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
	"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
	"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
	"PRICE_CODE" => $arParams["PRICE_CODE"],
	"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
	"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

	"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
	"ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] ?? ''),
	"PARTIAL_PRODUCT_PROPERTIES" => ($arParams["PARTIAL_PRODUCT_PROPERTIES"] ?? ''),
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
	"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
	"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
	"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
	'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
	'CURRENCY_ID' => $arParams['CURRENCY_ID'],
	'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
	'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

	'LABEL_PROP' => $arParams['LABEL_PROP'],
	'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
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

	'BY_LINK' => $arParams['BY_LINK'],
	'ALLOW_WO_SECTION' => $arParams['ALLOW_WO_SECTION'],

	'HIDE_DETAIL_LINKS' => $arParams['HIDE_DETAIL_LINKS'],
	'RETURN_IF_EMPTY' => $arParams['RETURN_IF_EMPTY'],
	'BLOCK_TITLE' => Loc::getMessage('SEARCH_PAGE_FOUND_PRODUCTS'),
	'PROP_CODE_BRAND' => $arParams['PROP_CODE_BRAND'],
	'PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
	'OFFERS_PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
	'ENABLE_PREVIEW_PICTURE' => isset($arParams['LIST_ENABLE_PREVIEW_PICTURE']) ? $arParams['LIST_ENABLE_PREVIEW_PICTURE'] : 'N',
	'PREVIEW_PICTURE_SWITCHER' => isset($arParams['LIST_PREVIEW_PICTURE_SWITCHER']) ? $arParams['LIST_PREVIEW_PICTURE_SWITCHER'] : 'N',
	'SORT_FIELDS' => $arParams['SORT_FIELDS'],
	'SORT_DEFAULT_FIELD' => $arParams['SORT_DEFAULT_FIELD'],
	'SORT_DEFAULT_ORDER' => $arParams['SORT_DEFAULT_ORDER'],
	'PERPAGE_FIELDS' => $arParams['PERPAGE_FIELDS'],
	'PERPAGE_DEFAULT' => $arParams['PERPAGE_DEFAULT'],
	'USE_STORE' => $arParams['USE_STORE'],
	'STORES' => $arParams['STORES']
];


$this->SetViewTarget('catalog_filter');

$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	"catalog",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => "",
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"PRICE_CODE" => $arParams["~PRICE_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SAVE_IN_SESSION" => "N",
		"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		"SEF_MODE" => 'N',
		"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
		"FILTER_ENABLE_HIDE_NOT_AVAILABLE" => $arParams["FILTER_ENABLE_HIDE_NOT_AVAILABLE"] ?? 'N',
		"PREFILTER_NAME" => "searchFilter"
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);

$this->endViewTarget();

global ${$arParams['FILTER_NAME']};
${$arParams['FILTER_NAME']} = array_merge(
	${$arParams['FILTER_NAME']},
	$searchFilter
);
?>

<div class="row">

	<div class="col-12 col-xl-9 order-2 order-xl-1">
		<?$APPLICATION->IncludeComponent(
			'redsign:b2bportal.catalog.section',
			'',
			$componentSectionParams
		);?>
	</div>

	<div class="col-12 col-xl-3 order-1 order-xl-2">
		<?php
		$APPLICATION->ShowViewContent('catalog_search');

		if (!$notFound)
		{
			$APPLICATION->ShowViewContent('catalog_filter');
		}
		?>
	</div>
</div>
