<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale;

$order = \Bitrix\Sale\Order::load($_REQUEST['id_order']);
$shipmentCollection = $order->getShipmentCollection()->getNotSystemItems();


$basket = $order->getBasket();

foreach ($shipmentCollection as $shipment) {
    $shipmentItemCollection = $shipment->getShipmentItemCollection();

    if ($shipment->getShipmentCode() == $_REQUEST['id']) {
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        foreach ($shipmentItemCollection as $item) {
            $item->setQuantity(0);
            $item->delete();
            $item->save();
        }
        $shipment->delete();
        $shipment->save();
    }
}
$order->save();
echo "Отгрузка №".$_REQUEST['id']." была удалена.";
