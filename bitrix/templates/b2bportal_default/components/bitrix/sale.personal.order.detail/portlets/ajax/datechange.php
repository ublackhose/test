<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale;


$date_input = strtotime($_REQUEST['DATE']);
$newformat = date('d.m.Y',$date_input);


$dbRes = \Bitrix\Sale\PropertyValueCollection::getList([
    'select' => ['*'],
    'filter' => [
        '=ORDER_ID' => 123,
    ]
]);

$id_pr = null;
while ($item = $dbRes->fetch())
{
    if($item['CODE'] == "DATE_DELIVERY"){
        $id_pr =  $item['ID'];
    }
    print_r($item);
}


$order = \Bitrix\Sale\Order::load($_REQUEST['ID']);
$collection = $order->getPropertyCollection();
$propertyValue = $collection->getItemById($id_pr);
$r = $propertyValue->setField('VALUE', $newformat);
if (!$r->isSuccess())
{
    print_r($r->getErrorMessages());
}

$order->save();