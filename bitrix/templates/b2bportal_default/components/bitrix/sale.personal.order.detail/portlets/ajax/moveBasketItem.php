<?php


include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include ($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/moveBasket.php");



moveBasketItem($_REQUEST['order_id'],$_REQUEST['id_product'],$_REQUEST['shipment-id-to'],$_REQUEST['shipment-id-from']);



