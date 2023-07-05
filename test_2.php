<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

echo 7198;


Cmodule::IncludeModule('catalog');
$PRODUCT_ID = 7181; // id товара
$arFields = array('QUANTITY' => 1000);
CCatalogProduct::Update($PRODUCT_ID, $arFields);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>