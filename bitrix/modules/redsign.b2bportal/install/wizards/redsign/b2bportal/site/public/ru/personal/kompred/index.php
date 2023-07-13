<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Коммерческие предложения");

?>
<?$APPLICATION->IncludeComponent(
	"redsign:kompred", 
	".default", 
	array(
		"DEFAULT_LOGO" => "#SITE_DIR#include/logo_color.png",
		"PROP_VENDOR_CODE" => "ARTNUMBER",
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "#SITE_DIR#personal/kompred/",
		"DEFAULT_CONTACTS" => "+7 (000) 000 00 <br> pro@redsign.ru",
		"LIST_USE_SEARCH" => "Y",
		"LIST_DATE_FORMAT" => "d.m.Y",
		"LIST_PAGE_SIZE" => "20",
		"MAKE_SHORTLINK" => "N",
		"SEF_URL_TEMPLATES" => array(
			"list" => "",
			"create" => "create/",
			"edit" => "edit/#ID#/",
			"download" => "download/#CODE#/",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>