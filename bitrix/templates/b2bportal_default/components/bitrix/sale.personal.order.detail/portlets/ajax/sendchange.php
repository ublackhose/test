<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Sale;

echo 123;
$a = new OrderUpdate($_REQUEST['action'],$_REQUEST['params']);

$a->action();


class OrderUpdate{

    private $actions = null;
    private $arParams = null;

    public function __construct($act, $arP)
    {
        $this->actions = $act;
        $this->arParams = json_decode($arP,true);
    }

    public function action(){
        switch ($this->actions) {
            case 'update':

                $id = $this->arParams['id'];
                $products = $this->arParams['products'];
                $order = \Bitrix\Sale\Order::load($id);
                $basket = $order->getBasket();


                foreach ($basket as $basketItem) {
                        $zapID = $basketItem->getField('ID');
                        $basket->getItemById($zapID)->delete();
                }

                foreach ($products as $product) {
                    $item = $basket->createItem('catalog', $product['id']);
                    $item->setFields(array(
                        'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
                        'LID' => \Bitrix\Main\Context::getCurrent()->getSite(),
                        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                    ));
                    $item->setField("QUANTITY", $product['quantity']);
                    $newBasketItems[] = $item;
                }


                $shipmentCollection = $order->getShipmentCollection();

                foreach ($shipmentCollection as $shipment) {
                    if (!$shipment->isSystem()) {
                        foreach ($newBasketItems as $newBasketItem) {
                            /** @var \Bitrix\Sale\Shipment $shipment */
                            $shipmentItemCollection = $shipment->getShipmentItemCollection();
                            $shipmentItem = $shipmentItemCollection->createItem($newBasketItem);
                            $shipmentItem->setQuantity($item->getQuantity());
                        }
                        break;
                    }
                }

                $discount = $order->getDiscount();
                \Bitrix\Sale\DiscountCouponsManager::clearApply(true);
                \Bitrix\Sale\DiscountCouponsManager::useSavedCouponsForApply(true);
                $discount->setOrderRefresh(true);
                $discount->setApplyResult(array());

                /** @var \Bitrix\Sale\Basket $basket */
                if (!($basket = $order->getBasket())) {
                    throw new \Bitrix\Main\ObjectNotFoundException('Entity "Basket" not found');
                }

                $basket->refreshData(array('PRICE', 'COUPONS'));
                $discount->calculate();
                $order->save();

                echo "Усппех";
                break;
            case 'update_dilivery':
                $id = $this->arParams['id'];
                $order = \Bitrix\Sale\Order::load($id);
                $shipmentCollection = $order->getShipmentCollection();
                print_r(get_class_methods($shipmentCollection));
//                $shipmentCollection->resetCollection();
                $deliveryData = [
                    'DELIVERY_ID' => $this->arParams['id_delivery'],
                    'DELIVERY_NAME' => $this->arParams['name_delivery'],
                    'ALLOW_DELIVERY' => 'Y',
                    'PRICE_DELIVERY' => 100,
                    'CUSTOM_PRICE_DELIVERY' => 'Y'
                ];

                foreach ($shipmentCollection as $shipment)
                {

//                    $shipment->setFields($deliveryData);
//                    print_r($shipment->);
//                    print_r(get_class_methods($shipment));
////                    $shipment-delete();
//                    if (!$shipment->isSystem())
//                        $shipment->allowDelivery();
                }


                echo "Усппех";
                break;
        }
    }

    public function UpdateProducts(){

    }
}


