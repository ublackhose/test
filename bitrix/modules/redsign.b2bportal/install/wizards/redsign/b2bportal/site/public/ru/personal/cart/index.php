<?php

use Bitrix\Main\Loader;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 */

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");

Loader::includeModule('redsign.b2bportal');
?>

<div class="row">
	<div class="col-xl-7">

<?php
$APPLICATION->IncludeComponent(
	"redsign:vbasket.select",
	"cart",
	array()
);
?>

<?php
$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket",
	"cart",
	array(
		"ACTION_VARIABLE" => "basketAction",
		"ADDITIONAL_PICT_PROP_#CATALOG_CATALOG_IBLOCK_ID#" => "MORE_PHOTO",
		"ADDITIONAL_PICT_PROP_#OFFERS_OFFERS_IBLOCK_ID#" => "MORE_PHOTO",
		"AUTO_CALCULATION" => "Y",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"COLUMNS_LIST_EXT" => array(
			0 => "DISCOUNT",
			1 => "DELETE",
			2 => "DELAY",
			3 => "TYPE",
			4 => "SUM",
			5 => "PROPERTY_ARTNUMBER",
		),
		"COLUMNS_LIST_MOBILE" => array(
			0 => "DISCOUNT",
			1 => "DELETE",
			2 => "DELAY",
			3 => "TYPE",
			4 => "SUM",
		),
		"COMPATIBLE_MODE" => "N",
		"CORRECT_RATIO" => "Y",
		"DEFERRED_REFRESH" => "N",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"DISPLAY_MODE" => "compact",
		"EMPTY_BASKET_HINT_PATH" => "#SITE_DIR#catalog/",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"HIDE_COUPON" => "Y",
		"LABEL_PROP" => "",
		"PATH_TO_ORDER" => "#SITE_DIR#personal/order/make/",
		"PRICE_DISPLAY_MODE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
		"QUANTITY_FLOAT" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FILTER" => "Y",
		"SHOW_RESTORE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "top",
		),
		"USE_DYNAMIC_SCROLL" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_GIFTS" => "Y",
		"USE_PREPAYMENT" => "N",
		"USE_PRICE_ANIMATION" => "Y",
		"COMPONENT_TEMPLATE" => "cart",
		"ARTICLE_PROPERTY" => "ARTNUMBER",
		"OFFERS_PROPS" => "",
		"USE_STORE" => "Y",
		"STORES" => array(
			0 => "1",
			1 => "2",
			2 => "",
		),
		"ENABLE_PREVIEW_PICTURE" => "Y",
		"SHOW_QUANTITY" => "Y",
		"PDF_PATH" => "#SITE_DIR#personal/cart/pdf.php",
		"KOMPRED_CREATE_URL" => "#SITE_DIR#personal/kompred/create/",
		"EXPORT_TYPES" => array(
			0 => "xlsx",
			1 => "csv",
			2 => "ods",
		)
	),
	false
);
?>

<?php
$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () {
	$this->title('Добавить товары к заказу');
}));

$portlet->body(function () use ($APPLICATION) {
	?><div class="row"><?
		?><div class="col-md-6 position-static"><?
			$APPLICATION->IncludeComponent(
				"redsign:b2bportal.catalog.search.article",
				"",
				array(
					"IBLOCK_ID" => "#CATALOG_CATALOG_IBLOCK_ID#",
					"PROP_CODE" => "ARTNUMBER",
					"OFFERS_PROP_CODE" => "ARTNUMBER",
					"PRICES" => array(
						"BASE"
					),
					"PROPS" => array(),
					"CONVERT_CURRENCY" => "Y",
					"CURRENCY_ID" => "RUB"
				)
			);
		?></div><?
		?><div class="col-md-6"><?
			?><span class="mr-4">или...</span><?
			$APPLICATION->IncludeComponent(
				"redsign:b2bportal.basket.imports",
				"",
				array(
					"IBLOCK_ID" => "#CATALOG_CATALOG_IBLOCK_ID#",
					"PROP_CODE" => "ARTNUMBER",
					"OFFERS_PROP_CODE" => "ARTNUMBER",
				)
			);
		?></div><?
	?></div><?
});

$portlet->render();
?>

<?php
$portlet = new Portlet();

$portlet->body(function () use ($APPLICATION) {
	?><div class="row"><?
		?><div class="col-12"><?
			?><?$APPLICATION->ShowViewContent('basket-summary')?><?
		?></div><?
	?></div><?
});

$portlet->render();
?>

	</div>
	<div class="col-xl-5">

		<?$APPLICATION->IncludeComponent(
			"redsign:b2bportal.catalog.filter",
			"",
			array(
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "#CATALOG_CATALOG_IBLOCK_ID#",
				"FILTER_NAME" => "arrFilterCart",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600000",
				"PRICE_CODE" => array(),
				"FIELD_CODE" => array(
					"SUBSECTIONS",
					"ELEMENT_NAME"
				),
			)
		);?>

		<?$APPLICATION->IncludeComponent(
			"redsign:b2bportal.catalog.section",
			".default",
			array(
				"COMPONENT_TEMPLATE" => ".default",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "#CATALOG_CATALOG_IBLOCK_ID#",
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"FILTER_NAME" => "arrFilterCart",
				"INCLUDE_SUBSECTIONS" => "Y",
				"SHOW_ALL_WO_SECTION" => "N",
				"CUSTOM_FILTER" => "",
				"HIDE_NOT_AVAILABLE" => "N",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "asc",
				"ELEMENT_SORT_FIELD2" => "id",
				"ELEMENT_SORT_ORDER2" => "desc",
				"OFFERS_SORT_FIELD" => "sort",
				"OFFERS_SORT_ORDER" => "asc",
				"OFFERS_SORT_FIELD2" => "id",
				"OFFERS_SORT_ORDER2" => "desc",
				"PAGE_ELEMENT_COUNT" => "5",
				"LINE_ELEMENT_COUNT" => "",
				"PROPERTY_CODE" => array(
					0 => "ARTNUMBER",
					1 => "MANUFACTURER",
					2 => "",
				),
				"OFFERS_FIELD_CODE" => array(
					0 => "",
					1 => "",
				),
				"OFFERS_PROPERTY_CODE" => array(
					0 => "ARTNUMBER",
					1 => "COLOR_REF",
					2 => "SIZES_SHOES",
					3 => "SIZES_CLOTHES",
					4 => "",
				),
				"BACKGROUND_IMAGE" => "-",
				"SECTION_URL" => "",
				"DETAIL_URL" => "",
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SEF_MODE" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "Y",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "N",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "N",
				"META_DESCRIPTION" => "-",
				"SET_LAST_MODIFIED" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"CACHE_FILTER" => "N",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRICE_CODE" => array(
					0 => "BASE",
				),
				"USE_PRICE_COUNT" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"PRICE_VAT_INCLUDE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"BASKET_URL" => "#SITE_DIR#personal/cart/",
				"USE_PRODUCT_QUANTITY" => "N",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"ADD_PROPERTIES_TO_BASKET" => "N",
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRODUCT_PROPERTIES" => array(
				),
				"OFFERS_CART_PROPERTIES" => array(
				),
				"DISPLAY_COMPARE" => "N",
				"PAGER_TEMPLATE" => "b2bportal",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Товары",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => "",
				"COMPATIBLE_MODE" => "N",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"BLOCK_TITLE" => "Найденные товары",
				"SORT_FIELDS" => array(
					0 => "name",
					1 => "catalog_quantity",
					2 => "catalog_price_scale_1",
				),
				"SORT_DEFAULT_FIELD" => "name",
				"SORT_DEFAULT_ORDER" => "asc",
				"PERPAGE_FIELDS" => array(
					0 => "10",
					1 => "15",
					2 => "20",
					3 => "50",
					4 => "5",
					5 => "",
				),
				"OFFER_TREE_PROPS" => array(
					0 => "COLOR_REF",
					1 => "SIZES_SHOES",
					2 => "SIZES_CLOTHES",
				),
				"PRODUCT_DISPLAY_MODE" => "Y",
				"PERPAGE_DEFAULT" => "5",
				"ALLOW_WO_SECTION" => "Y",
				"BY_LINK" => "Y",
				"PROP_CODE_ARTICLE" => "ARTNUMBER",
				"OFFERS_PROP_CODE_ARTICLE" => "ARTNUMBER",
				"PROP_CODE_BRAND" => "MANUFACTURER",
				"RS_VIEW_MODE" => "compact",
				"ENABLE_PREVIEW_PICTURE" => "N",
				"PREVIEW_PICTURE_SWITCHER" => "Y",
				"USE_STORE" => "Y",
				"STORES" => array(
					0 => "1",
					1 => "2",
					2 => "",
				),
				"SHOW_MAX_QUANTITY" => "Y",
				"RELATIVE_QUANTITY_FACTOR" => "100"
			),
			false
		);?>
	</div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
