<?php

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
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? array($arParams['COMMON_ADD_TO_BASKET_ACTION']) : array());
}
else
{
	$basketAction = (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION'] : array());
}

$componentElementParams = array(
	'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
	'IBLOCK_ID' => $arParams['IBLOCK_ID'],
	'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
	'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
	'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
	'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
	'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
	'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
	'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
	'CHECK_SECTION_ID_VARIABLE' => (isset($arParams['DETAIL_CHECK_SECTION_ID_VARIABLE']) ? $arParams['DETAIL_CHECK_SECTION_ID_VARIABLE'] : ''),
	'CACHE_TYPE' => $arParams['CACHE_TYPE'],
	'CACHE_TIME' => $arParams['CACHE_TIME'],
	'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
	'SET_TITLE' => $arParams['SET_TITLE'],
	'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
	'MESSAGE_404' => $arParams['~MESSAGE_404'],
	'SET_STATUS_404' => $arParams['SET_STATUS_404'],
	'SHOW_404' => $arParams['SHOW_404'],
	'FILE_404' => $arParams['FILE_404'],
	"PRICE_CODE" => $arParams["PRICE_CODE"],
	'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
	'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
	'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
	'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
	'SECTION_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
	'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['element'],
	'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
	'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
	'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'],
	'LABEL_PROP' => $arParams['LABEL_PROP'] ?? [],
	'LINES_PROPERTIES' => $arParams['DETAIL_LINES_PROPERTIES'] ?? [],
	'PROP_CODE_BRAND' => $arParams['PROP_CODE_BRAND'],
	'PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
	'OFFERS_PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
	'SHOW_MAX_QUANTITY' => $arParams["SHOW_MAX_QUANTITY"],
	'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
	'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
	'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
	'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
	'USE_STORE' => $arParams['USE_STORE'],
	'STORES' => $arParams['STORES'],

	// linked lists fields
	"LIST_ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
	"LIST_ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
	"LIST_ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
	"LIST_ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
	"LIST_PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
	"LIST_LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
	"LIST_OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
	"LIST_OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
	"LIST_OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
);

$componentElementParams['PROP_MORE_PHOTO'] = $arParams['PROP_MORE_PHOTO'];

foreach ($arParams as $paramCode => $paramValue)
{
	if (substr($paramCode, 0, strlen('LABEL_PROP_MODIFIER_')) === 'LABEL_PROP_MODIFIER_')
	{
		$componentElementParams[$paramCode] = $paramValue;
	}
}
?>

<div class="row" data-sticky-container>
	<div class="col-12 col-xl-3">
		<?php $elementId = $APPLICATION->IncludeComponent(
			'bitrix:catalog.element',
			'catalog',
			$componentElementParams,
			$component
		);?>
	</div>
	<div class="col-12 col-xl-9">
		<?php include 'include/mods.php'; ?>
		<?php $APPLICATION->ShowViewContent('catalog-element-data'); ?>
		<?php include 'include/lines.php'; ?>

	</div>
</div>
