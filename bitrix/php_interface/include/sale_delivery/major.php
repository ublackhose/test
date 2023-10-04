<?

namespace Sale\Major\LTL;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;
use Bitrix\Main\Error;
use Bitrix\Sale\Delivery\ExtraServices\Manager;

include_once($_SERVER["DOCUMENT_ROOT"] . '/majorltl.php');


class MajorLTL extends Base
{
    public static function getClassTitle()
    {
        return 'Major (Сборные Грузы)';
    }

    public static function getClassDescription()
    {
        return 'Мэйджор Экспресс - компания, специализирующаяся на предоставлении услуг по экспресс-доставке корреспонденции и грузов в любую точку мира. Высокий уровень оказываемых услуг, кратчайшие сроки, гибкая ценовая политика, максимальная открытость и клиентоориентированность позволяют нам с уверенностью говорить о лучшем на сегодняшний день в России соотношении цена/скорость/качество оказываемых услуг';
    }


    public static function raschet($weight){

        $weight = $weight/1000;
        if($weight < 10){
            $le = 250/1000;
            $he = 300/1000;
            $we = 170/1000;
            $valume = $le * $he * $we;
        }else if($weight >= 10 && $weight < 40){
            $le = 550/1000;
            $he = 350/1000;
            $we = 350/1000;
            $valume = $le * $he * $we;
        }else if($weight >= 40 && $weight < 100){
            $le = 1200/1000;
            $he = 800/1000;
            $we = 600/1000;
            $valume = $le * $he * $we;
        }else if($weight >= 100){
            $le = 1200/1000;
            $he = 800/1000;
            $we = 1500/1000;
            $valume = $le * $he * $we;
        }


        return round($valume,2);
    }

    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
    {




        $weight = $shipment->getWeight() / 1000000; // вес отгрузки

        $order = $shipment->getCollection()->getOrder(); // заказ
        $price = $order->getPrice();//цена
        $props = $order->getPropertyCollection();
        $locationCode = $props->getDeliveryLocation()->getValue(); // местоположение
        $location = \Bitrix\Sale\Location\LocationTable::getByCode($locationCode, array(
            'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID),
            'select' => array('NAME_RU' => 'NAME.NAME')
        ))->fetch();;


        $res = getSoapDiliveryMajorLTL($location['NAME_RU'], $weight, $price,MajorLTL::raschet($weight));


        $enum = $shipment->getDelivery()->getExtraServices()->getItems();
        $test = null;
        if (isset($enum[4])) {
            $params = $enum[4]->getParams();
            foreach ($params['PRICES'] as $key => $param) {
                if ($key == $enum[4]->getValue()) {
                    $test = $param["TITLE"];
                }
            }
        }





        if ($res && $test) {
            $type = null;
            foreach ($res as $dilivery_type) {
                if ($dilivery_type['DeliveryName'] == $test) {
                    $type = $dilivery_type;
                }
            }

            if ($type) {
                $result = new CalculationResult();
                $result->setDeliveryPrice($type['Tariff'] + $type['Insurance']);
                $result->setPeriodDescription('от ' . $type['DeliveryPeriod'] . ' день');
                return $result;

            } else {
                $result = new CalculationResult();
                $result->addError(
                    new Error(
                        'DELIVERY_CALCULATION'
                    )
                );
                return $result;
            }
        } else {
            $result = new CalculationResult();
            $result->addError(
                new Error(
                    'DELIVERY_CALCULATION'
                )
            );
            return $result;
        }
    }

    protected function getConfigStructure()
    {
        return array(
            "MAIN" => array(
                "TITLE" => 'Настройка обработчика',
                "DESCRIPTION" => 'Настройка обработчика',
                "ITEMS" => array(
                    "PRICE" => array(
                        "TYPE" => "NUMBER",
                        "MIN" => 0,
                        "NAME" => 'Стоимость доставки за грамм'
                    )
                )
            )
        );
    }

    public function isCalculatePriceImmediately()
    {
        return true;
    }

    public static function whetherAdminExtraServicesShow()
    {
        return true;
    }


}

?>