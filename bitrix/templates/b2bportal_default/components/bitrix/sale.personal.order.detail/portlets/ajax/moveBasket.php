<?php


function moveBasketItem($id_order, $id_product, $shipment_id_to, $shipment_id_from)
{
    $order = \Bitrix\Sale\Order::load($id_order);
    $basket = $order->getBasket();
    $shipmentCollection = $order->getShipmentCollection();
    $cur_basket_item = null;

    foreach ($basket as $b) {
        if ($b->getFields()->getValues()['PRODUCT_ID'] == $id_product) {
            $cur_basket_item = $b;
        }
    }

    if ($cur_basket_item) {
        $shipment_to = null;
        $shipment_from = null;

        foreach ($shipmentCollection as $shipment) {
            $shipment_id = $shipment->getId();

            if ($shipment_id == $shipment_id_to) {
                $shipment_to = $shipment;
            }
            if ($shipment_id == $shipment_id_from) {
                $shipment_from = $shipment/*->getShipmentItemCollection()*/
                ;
            }
        }

        if ($shipment_to && $shipment_from) {
            foreach ($shipment_from->getShipmentItemCollection() as $item) {
                $basketItem = $item->getBasketItem();
                if ($basketItem->getProductId() == $id_product
                ) {
                    if (!$shipment_from->isSystem() || !$shipment_to->isSystem()) {
                        $item->delete();
                    }
                }
            }
            $item = $shipment_to->getShipmentItemCollection()->createItem($cur_basket_item);
            $item->setQuantity($cur_basket_item->getQuantity());
        }
    }

    $shipment_to->save();
    $shipment_from->save();
    $shipment->save();
    $order->save();
}