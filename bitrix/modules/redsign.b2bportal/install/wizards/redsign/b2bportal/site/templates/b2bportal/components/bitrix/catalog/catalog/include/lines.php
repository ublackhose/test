<?php

use Bitrix\Main\Web\Json;
use Redsign\B2BPortal\UI\Portlet;
use Redsign\DevFunc\Iblock\CustomProperty\CustomFilter;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/** @var array */
global $catalogElement;

if (isset($catalogElement['LINES_PROPERTIES']) && is_array($catalogElement))
{
	foreach ($catalogElement['LINES_PROPERTIES'] as $code => $property)
	{
		if ($property['PROPERTY_TYPE'] === 'E' || $property['USER_TYPE'] === CustomFilter::USER_TYPE)
		{
			$componentSectionParams = [
				"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
				"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
				"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
				"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
				"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
				"INCLUDE_SUBSECTIONS" => 'N',
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_FILTER" => 'Y',
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SET_TITLE" => $arParams["SET_TITLE"],
				"MESSAGE_404" => $arParams["~MESSAGE_404"],
				"SET_STATUS_404" => 'N',
				"SHOW_404" => 'N',
				"DISPLAY_COMPARE" => '',
				"PAGE_ELEMENT_COUNT" => 50,
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
				"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

				"DISPLAY_TOP_PAGER" => 'N',
				"DISPLAY_BOTTOM_PAGER" => 'Y',
				"PAGER_TITLE" => '',
				"PAGER_SHOW_ALWAYS" => 'Y',
				"PAGER_TEMPLATE" => '',
				"PAGER_DESC_NUMBERING" => 'N',
				"PAGER_DESC_NUMBERING_CACHE_TIME" => 36000,
				"PAGER_SHOW_ALL" => 'N',
				"PAGER_BASE_LINK_ENABLE" => 'N',

				"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
				"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),
				"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
				'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
				'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
				'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
				'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
				'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
				'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
				'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
				'MAX_QUANTITY' => $arParams['MAX_QUANTITY'] ?? '',
				'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),
				"ADD_SECTIONS_CHAIN" => '',
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"FILL_ITEM_ALL_PRICES" => (is_array($arParams['PRICE_CODE']) && count($arParams['PRICE_CODE']) > 1) ? 'Y' : $arParams['FILL_ITEM_ALL_PRICES'],
				'HIDE_DETAIL_LINKS' => 'N',
				'BLOCK_TITLE' => $property['NAME'],
				'PROP_CODE_BRAND' => $arParams['PROP_CODE_BRAND'],
				'PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
				'OFFERS_PROP_CODE_ARTICLE' => $arParams['PROP_CODE_ARTICLE'],
				'ENABLE_PREVIEW_PICTURE' => isset($arParams['LIST_ENABLE_PREVIEW_PICTURE']) ? $arParams['LIST_ENABLE_PREVIEW_PICTURE'] : 'N',
				'PREVIEW_PICTURE_SWITCHER' => isset($arParams['LIST_PREVIEW_PICTURE_SWITCHER']) ? $arParams['LIST_PREVIEW_PICTURE_SWITCHER'] : 'N',
				'USE_STORE' => $arParams['USE_STORE'],
				'STORES' => $arParams['STORES'],
				'HIDE_FOOT' => 'Y',
				'RETURN_IF_EMPTY' => 'Y',
				'ADD_PREVIEW_THUMBNAIL' => $arParams['LIST_ADD_PREVIEW_THUMBNAIL'],
				'PREVIEW_THUMBNAIL_WIDTH' => $arParams['LIST_PREVIEW_THUMBNAIL_WIDTH'],
				'PREVIEW_THUMBNAIL_HEIGHT' => $arParams['LIST_PREVIEW_THUMBNAIL_HEIGHT'],

				'STORAGE_PREFIX' => 'catalog_line_' . $property['ID'],
			];

			if ($property['PROPERTY_TYPE'] === 'E')
			{
				global $linkElementsFilter;
				$linkElementsFilter = ['=ID' => $property['VALUE']];

				$APPLICATION->IncludeComponent(
					'redsign:b2bportal.catalog.section',
					'',
					$componentSectionParams + [
						"IBLOCK_ID" => $property["LINK_IBLOCK_ID"],
						"FILTER_NAME" => 'linkElementsFilter',
					]
				);

				unset($linkElementsFilter);
			}
			elseif ($property['USER_TYPE'] === CustomFilter::USER_TYPE)
			{
				if (is_array($property['VALUE']) && $property['VALUE'])
				{
					$APPLICATION->IncludeComponent(
						'redsign:b2bportal.catalog.section',
						'',
						$componentSectionParams + [
						'IBLOCK_ID' => $arParams['IBLOCK_ID'],
						'FILTER_NAME' => $arParams['FILTER_NAME'],
						'CUSTOM_FILTER' => Json::encode($property['VALUE'])
						]
					);
				}
			}
		}
		else
		{
			Portlet::simple($property['NAME'], function () use ($property) {
				echo '<div class="d-block">' .
					(is_array($property['DISPLAY_VALUE']) ? implode(' / ', $property['DISPLAY_VALUE']) : $property['DISPLAY_VALUE']) .
				'</div>';
			})->render();
		}
	}
}
