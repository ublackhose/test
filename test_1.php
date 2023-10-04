<?php

include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


$order = \Bitrix\Sale\Order::load(200);
$basket = $order->getBasket();
//и получаем Коллекцию Отгрузок текущего Заказа
$shipmentCollection = $order->getShipmentCollection()->getNotSystemItems();


echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
print_r(get_class_methods($shipmentCollection));
echo "</pre>";

$aaaaaaaaaaaaaaa = null;

foreach ($basket as $b){

}

foreach ($shipmentCollection as $shipment) {
    $shipment_id = $shipment->getId();

    //пропускаем системные
    if ($shipment->isSystem()) {
        continue;
    }

    $arShipments[$shipment_id] = array(
        'ID' => $shipment_id,
        'ACCOUNT_NUMBER' => $shipment->getField('ACCOUNT_NUMBER'),
        'ORDER_ID' => $shipment->getField('ORDER_ID'),
        'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
        'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
        'BASKET' => array(),
    );

    //получаем Коллекцию Товаров в Корзине каждой Отгрузки
    $shipmentItemCollection = $shipment->getShipmentItemCollection();



    if($shipment->getId() == 501){
        $cur_sh = $shipment->getShipmentItemCollection();
    }


    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
    print_r($aaaaaaaaaaaaaaa);
    echo "</pre>";



    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
    print_r(get_class_methods($cur_sh));
    echo "</pre>";

    $item = $cur_sh->createItem($aaaaaaaaaaaaaaa);
    $item->setQuantity($aaaaaaaaaaaaaaa->getQuantity());

//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r(get_class_methods($cur_sh));
//    echo "</pre>";
////
//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r($shipmentItemCollection);
//    echo "</pre>";

//    foreach ($shipmentItemCollection as $item) {
//
////        $r = $item->delete();
////        if (!$r->isSuccess())
////        {
////            var_dump($r->getErrorMessages());
////        }
//
//
//
//        $cur_sh->createItem($aaaaaaaaaaaaaaa);
//
////        $item->create($cur_sh);
//
////        \Bitrix\Sale\ShipmentItem::create();
//        //объект Товара в корзине Отгрузки
////        $basketItem = $item->getBasketItem();
////
////
////        //не учитываем товары, которые нельзя купить или которые отложены
////        if (!$basketItem->canBuy() || $basketItem->isDelay()) {
////            continue;
////        }
////
////        $arItem = array(
////            'PRODUCT_ID' => $basketItem->getProductId(),
////            'NAME' => $basketItem->getField('NAME'),
////            'PRICE' => $basketItem->getPrice(),    // за единицу
////            'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
////            'QUANTITY' => $basketItem->getQuantity(),
////            'WEIGHT' => $basketItem->getWeight(),
////        );
////
////        $arShipments[$shipment_id]['BASKET'][$arItem['PRODUCT_ID']] = $arItem;
//    }
    $cur_sh->save();
    $shipment->save();
}



$order->save();




