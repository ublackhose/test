<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("");

use Redsign\B2BPortal\Services\Sale\PersonalProfile;
require_once __DIR__ . '/bitrix/php_interface/crm_import/crest.php';

$result = CRest::call(
        'crm.lead.get',
        [
            'id' => 68139
        ]
    );

echo '<pre data-test style="color: #c3c3c3; background: #282923; padding: 15px 5px; margin: 0;">';
print_r($result);
echo '</pre>';


// $query = new \Bitrix\Main\Entity\Query(Bitrix\Sale\Internals\UserPropsTable::getEntity());
// $profiles = $query
//     ->setSelect(array("ID", "NAME", "PERSON_TYPE_ID"))
//     ->setFilter(array("PERSON_TYPE_ID" => [1, 2]))
//     ->exec()
//     ->fetchAll();

// $userProfileOrder = [];

// foreach ($profiles as $key => $profile) {
//     $db_propVals = CSaleOrderUserPropsValue::GetList(
//         ["ID" => "ASC"],
//         ["USER_PROPS_ID" => $profile['ID']],
//         false,
//         false,
//         ["ID", "USER_PROPS_ID", "ORDER_PROPS_ID", "NAME", "VALUE", "PROP_ID", "PROP_CODE"]
//     );

//     $inn = 0;
//     $kpp = 0;
//     $profileArray = [];

//     while ($arPropVals = $db_propVals->Fetch()){
//         $profileArray[$arPropVals['PROP_CODE']] = $arPropVals;
    
//         if ($arPropVals['PROP_CODE'] == 'INN') {
//             $inn = $arPropVals['VALUE'];
//         }
//         if ($arPropVals['PROP_CODE'] == 'KPP') {
//             $kpp = $arPropVals['VALUE'];
//         }
//     }

//     $userProfileOrder[$inn.$kpp] = $profileArray;
// }

// echo '<pre data-test style="color: #c3c3c3; background: #282923; padding: 15px 5px; margin: 0;">';
// print_r($userProfileOrder);
// echo '</pre>';











//CModule::IncludeModule("sale");
//
//$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
//$arFilter = Array("IBLOCK_ID"=>IntVal(5),"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",);
//$res = CIBlockElement::GetList(Array("ID"=>"DESC"), $arFilter, false, array(), $arSelect);
//


//
//
//$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
//$arFilter = Array("IBLOCK_ID"=>IntVal(5),"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y",);
//$res = CIBlockElement::GetList(Array("ID"=>"DESC"), $arFilter, false, array(), $arSelect);
//
//
//while($ob = $res->GetNextElement())
//{
//    $arFields = $ob->GetFields();
//    $res_2 = CIBlockElement::GetProperty(5, $arFields['ID'], "sort", "asc", array("CODE" => "CML2_TRAITS"));
//    $ratio = 1;
//    while ($ob_2 = $res_2->GetNext())
//    {
//        if($ob_2['DESCRIPTION'] == "МинимальныйРазмерПартииЗаказа"){
//
//            if($ob_2['VALUE'] > 1){
//                echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//                print_r($arFields);
//                echo "</pre>";
//                echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//                print_r($ob_2['VALUE']);
//                echo "</pre>";
//            }
//
//            if($ob_2['VALUE']!=0){
//                $ratio = $ob_2['VALUE'];
//            }
//        }
//    }
//
//    $r = CCatalogMeasureRatio::getList ( $arOrder = array(), $arFilter = array("PRODUCT_ID" => $arFields['ID']),
//        $arGroupBy = false, $arNavStartParams = false, $arSelectFields = array() );
//
//    if($ar_r = $r->GetNext()) {
////        CIBlockElement::SetPropertyValues($ELEMENT_ID, $IBLOCK_ID, $PROPERTY_VALUE, $PROPERTY_CODE);
//        CCatalogMeasureRatio::update($ar_r["ID"], array("RATIO" => $ratio));
//    }
//
//
//
//
//}

//$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
//$arFilter = Array("IBLOCK_ID"=>IntVal(5),"ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "NAME" => "%DTM%");
//$res = CIBlockElement::GetList(array(), $arFilter, false, Array("nPageSize"=>5), $arSelect);
//while($ob = $res->GetNextElement())
//{
//    $arFields = $ob->GetFields();
////    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
////    print_r($arFields);
////    echo "</pre>";
//
//    $ar_res = CCatalogProduct::GetByIDEx($arFields['ID']);
//
//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r($ar_res);
//    echo "</pre>";
//}


//$order = \Bitrix\Sale\Order::load(131);

//и получаем Коллекцию Отгрузок текущего Заказа
//$shipmentCollection = $order->getShipmentCollection()->getNotSystemItems();


//foreach ($shipmentCollection as $shipment) {
//    $shipment_id = $shipment->getId();
//
//    //пропускаем системные
//    if ($shipment->isSystem()) {
//        continue;
//    }
//
//    $arShipments[$shipment_id] = array(
//        'ID' => $shipment_id,
//        'ACCOUNT_NUMBER' => $shipment->getField('ACCOUNT_NUMBER'),
//        'ORDER_ID' => $shipment->getField('ORDER_ID'),
//        'DELIVERY_ID' => $shipment->getField('DELIVERY_ID'),
//        'PRICE_DELIVERY' => (float)$shipment->getField('PRICE_DELIVERY'),
//        'BASKET' => array(),
//    );
//
//    //получаем Коллекцию Товаров в Корзине каждой Отгрузки
//    $shipmentItemCollection = $shipment->getShipmentItemCollection();
//    foreach ($shipmentItemCollection as $item) {
//        //объект Товара в корзине Отгрузки
//        $basketItem = $item->getBasketItem();
//
//        //не учитываем товары, которые нельзя купить или которые отложены
//        if (!$basketItem->canBuy() || $basketItem->isDelay()) {
//            continue;
//        }
//
//        $arItem = array(
//            'PRODUCT_ID' => $basketItem->getProductId(),
//            'NAME' => $basketItem->getField('NAME'),
//            'PRICE' => $basketItem->getPrice(),    // за единицу
//            'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
//            'QUANTITY' => $basketItem->getQuantity(),
//            'WEIGHT' => $basketItem->getWeight(),
//        );
//
//        $arShipments[$shipment_id]['BASKET'][$arItem['PRODUCT_ID']] = $arItem;
//    }
//}
//
//
//echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//print_r($arShipments);
//echo "</pre>";


//$basket = $order->getBasket();
//
//foreach ($shipmentCollection as $shipment) {
//    $shipmentItemCollection = $shipment->getShipmentItemCollection();
//
//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r(get_class_methods($shipment));
//    echo "</pre>";
//
//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r($shipment->getShipmentCode());
//    echo "</pre>";
//
//    if ($shipment->getShipmentCode() == 334) {
//        $shipmentItemCollection = $shipment->getShipmentItemCollection();
//        foreach ($shipmentItemCollection as $item) {
////            $item->setField("DEDUCTED", "N");
//            $item->setQuantity(0);
//            $item->delete();
//            $item->save();
//        }
//
//        $shipment->delete();
//
//        $shipment->save();
//    }
//
//
//
////    foreach ($shipmentItemCollection as $item) {
////        $item->setField("DEDUCTED", "N");
////        $item->setQuantity(0);
////        $item->delete();
////        $item->save();
////    }
//
////    $shipment->delete();
////
////    $shipment->save();
//}
//
//
//$shipmentCollection = $order->getShipmentCollection();
//$shipment = $shipmentCollection->createItem(
//    \Bitrix\Sale\Delivery\Services\Manager::getObjectById(22)
//);
//$shipmentItemCollection = $shipment->getShipmentItemCollection();
//$shipment->setField('CURRENCY', $order->getCurrency());
//$shipment->setField('DELIVERY_ID', 22);
//
//
//
//
////foreach ($order->getBasket() as $item)
////{
////    $shipmentItem = $shipmentItemCollection->createItem($item);
////    $shipmentItem->setQuantity($item->getQuantity());
////}
//
//$shipment->save();
//
//$order->save();

//foreach ($basket as $basketItem) {
//
//}

//$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
//
//echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//print_r(get_class_methods($basket));
//echo "</pre>";
//
//echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//print_r($basket->getFUserId());
//echo "</pre>";
//
//
//
//
//
//
//if (CModule::IncludeModule('highloadblock')) {
//    $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
//    $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
//    $strEntityDataClass = $obEntity->getDataClass();
//}



////Добавление:
//if (CModule::IncludeModule('highloadblock')) {
//    $arElementFields = array(
//        'UF_BASKET' => Bitrix\Sale\Fuser::getId(),
//        'UF_PRODUCTS' => "test"
//    );
//    $obResult = $strEntityDataClass::add($arElementFields);
//    $ID = $obResult->getID();
//    $bSuccess = $obResult->isSuccess();
//}
//Получение списка:

//if (CModule::IncludeModule('highloadblock')) {
//    $rsData = $strEntityDataClass::getList(array(
//        'select' => array('ID','UF_BASKET','UF_PRODUCTS'),
//        'order' => array('ID' => 'ASC'),
//        'limit' => '50',
//    ));
//    while ($arItem = $rsData->Fetch()) {
//        $arItems[] = $arItem;
//    }
//}
//
//echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//print_r($arItems);
//echo "</pre>";

//$dbRes = \Bitrix\Sale\Order::getList([
//    'select' => ['ID'],
//    'filter' => [
//        "CANCELED" =>"N", //не отмененные
//        "PROPERTY.ORDER_PROPS_ID" => 10, //по свойству
//        "PROPERTY.VALUE" => '12323123', //и по его значению
//    ],
//    'order' => ['ID' => 'DESC']
//]);
//
//
//while ($order = $dbRes->fetch()){
//    echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
//    print_r($order);
//    echo "</pre>";
//}


// $documentData = "2023-08-02T10:58:38";


// echo "<pre style='background: #333333; color:#ffffff;border-radius: 5px; padding: 10px;'>";
// print_r(date($documentData));
// echo "</pre>";

?>
