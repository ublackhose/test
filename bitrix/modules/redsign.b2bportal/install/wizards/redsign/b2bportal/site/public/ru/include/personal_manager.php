<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?$APPLICATION->IncludeComponent(
	"redsign:b2bportal.personal.manager", 
	"topbar", 
	array(
		"COMPONENT_TEMPLATE" => "topbar",
		"IBLOCK_TYPE" => "system",
		"IBLOCK_ID" => "#MANAGERS_IBLOCK_ID#",
		"PROPS" => array(
			0 => "USER",
			1 => "NAME",
			2 => "PHOTO",
			3 => "PHONE_NUMBER",
			4 => "EMAIL",
			5 => "SKYPE",
			6 => "TELEGRAM",
			7 => "WHATSAPP",
			8 => "VIBER",
			9 => "",
		),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000"
	),
	false
);?>
