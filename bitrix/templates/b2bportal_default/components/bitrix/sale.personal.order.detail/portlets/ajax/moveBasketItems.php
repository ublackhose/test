<?php


include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include ($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/moveBasket.php");

$products = json_decode($_REQUEST['id_products']);
foreach ($products as $product){
    moveBasketItem($_REQUEST['order_id'],$product,$_REQUEST['shipment-id-to'],$_REQUEST['shipment-id-from']);
}




