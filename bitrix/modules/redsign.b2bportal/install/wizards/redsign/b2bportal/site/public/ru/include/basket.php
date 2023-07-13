<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
$APPLICATION->IncludeComponent(
	'redsign:vbasket.select', 
	'global',
	array(
		'CART_PATH' => '#SITE_DIR#personal/cart/'
	)
);
?>
