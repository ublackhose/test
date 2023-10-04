<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale;


$order = \Bitrix\Sale\Order::load($_REQUEST['ID']);
$propertyCollection = $order->getPropertyCollection();
$property = $propertyCollection->getItemByOrderPropertyCode("APPROVAL_DATE");
$sogl = $property->getValue();




$collection = $order->getShipmentCollection()->getNotSystemItems();
foreach ($collection as $shipment) {
    if ($shipment->getField('DELIVERY_ID') != 2) {
        CSaleOrder::StatusOrder($_REQUEST['ID'], 'K');
    }
}

print_r(get_class_methods($property));

$r = $property->setField('VALUE', 'Y');

if (!$r->isSuccess())
{
    print_r($r->getErrorMessages());
}

$order->save();

if($sogl == 'Y'){
    die();
}
