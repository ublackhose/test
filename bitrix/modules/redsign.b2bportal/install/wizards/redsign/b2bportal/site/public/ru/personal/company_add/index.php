<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создание компании");
?><?$APPLICATION->IncludeComponent(
	"redsign:b2bportal.sale.personal.profile.add",
	"",
	array(
		"COMPATIBLE_LOCATION_MODE" => "N",
		"ID" => "",
		"PATH_TO_DETAIL" => "#SITE_DIR#personal/companies/#ID#/",
		"PATH_TO_LIST" => "#SITE_DIR#personal/companies/",
		"SET_TITLE" => "Y",
		"USE_AJAX_LOCATIONS" => "N"
	)
);?><? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
