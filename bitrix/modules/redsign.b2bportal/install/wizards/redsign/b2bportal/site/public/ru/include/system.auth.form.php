<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?$APPLICATION->IncludeComponent(
	"redsign:b2bportal.sale.personal.profile.select", 
	"", 
	array(
		"ADD_COMPANY_URL" => "#SITE_DIR#personal/company_add/",
	),
	false
);?>
