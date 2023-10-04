<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale;

$order = \Bitrix\Sale\Order::load($_REQUEST['id_order']);

//и получаем Коллекцию Отгрузок текущего Заказа
$shipmentCollection = $order->getShipmentCollection()->getNotSystemItems();


$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem(
    \Bitrix\Sale\Delivery\Services\Manager::getObjectById(22)
);
$shipmentItemCollection = $shipment->getShipmentItemCollection();
$shipment->setField('CURRENCY', $order->getCurrency());
$shipment->setField('DELIVERY_ID', $_REQUEST['id']);

$shipment->save();

$order->save();
