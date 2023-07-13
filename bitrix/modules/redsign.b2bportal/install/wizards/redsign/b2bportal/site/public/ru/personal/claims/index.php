<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рекламации");
?><?$APPLICATION->IncludeComponent(
	"bitrix:support.wizard", 
	"claims", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"IBLOCK_ID" => "",
		"IBLOCK_TYPE" => "system",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"MESSAGES_PER_PAGE" => "50",
		"MESSAGE_MAX_LENGTH" => "70",
		"MESSAGE_SORT_ORDER" => "asc",
		"PROPERTY_FIELD_TYPE" => "",
		"PROPERTY_FIELD_VALUES" => "",
		"SECTIONS_TO_CATEGORIES" => "Y",
		"SELECTED_SECTIONS" => array(
		),
		"SET_PAGE_TITLE" => "Y",
		"SET_SHOW_USER_FIELD" => array(
			0 => "UF_ORDER_ID",
		),
		"SHOW_COUPON_FIELD" => "N",
		"SHOW_RESULT" => "Y",
		"TEMPLATE_TYPE" => "standard",
		"TICKETS_PER_PAGE" => "10",
		"COMPONENT_TEMPLATE" => "1",
		"ORDER_PATH" => "#SITE_DIR#personal/orders/#ORDER_NUMBER#/",
		"VARIABLE_ALIASES" => array(
			"ID" => "ID",
		)
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>