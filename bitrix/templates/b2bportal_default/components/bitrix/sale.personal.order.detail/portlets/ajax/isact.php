<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


$order = \Bitrix\Sale\Order::load($_REQUEST['id']);
$collection = $order->getPropertyCollection();

$propertyValue = $collection->getItemByOrderPropertyCode("ISAСT");


$r = $propertyValue->setField('VALUE', 'Y');
if (!$r->isSuccess())
{
    echo($r->getErrorMessages());
}else{
    echo "Акт сверки запрошен для заказа ".$_REQUEST['id'];
    $order->save();
}

