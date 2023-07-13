<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Баланс");
?><?$APPLICATION->IncludeComponent(
	"redsign:b2bportal.sale.balance.list",
	"",
	array(
	)
);?><? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
