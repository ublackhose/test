<?
namespace Sale\Handlers\Delivery;
use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;
use Bitrix\Main;
use Bitrix\Main\Error;
include_once ($_SERVER["DOCUMENT_ROOT"].'/majored.php');


class CustomHandler extends Base
{
    public static function getClassTitle()
    {
        return 'Major EX(Экспресс доставка)';
    }

    public static function getClassDescription()
    {
        return 'Мэйджор Экспресс - компания, специализирующаяся на предоставлении услуг по экспресс-доставке корреспонденции и грузов в любую точку мира. Высокий уровень оказываемых услуг, кратчайшие сроки, гибкая ценовая политика, максимальная открытость и клиентоориентированность позволяют нам с уверенностью говорить о лучшем на сегодняшний день в России соотношении цена/скорость/качество оказываемых услуг';
    }



    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
    {



        $weight = $shipment->getWeight()/1000000; // вес отгрузки

        $order = $shipment->getCollection()->getOrder(); // заказ
        $price = $order->getPrice();
        $props = $order->getPropertyCollection();
        $locationCode = $props->getDeliveryLocation()->getValue(); // местоположение
        $location = \Bitrix\Sale\Location\LocationTable::getByCode($locationCode, array(
            'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID),
            'select' => array('NAME_RU' => 'NAME.NAME')
        ))->fetch();;


        $res = getSoapDiliveryMajorED($location['NAME_RU'],$weight,$price);



        if($res){
            $result = new CalculationResult();
            $result->setDeliveryPrice($res['Tariff']+$res['Insurance']);
            $result->setPeriodDescription('от '.$res['DeliveryTime'].' день');

            return $result;
        }else{
            $result = new CalculationResult();
            $result->addError(
                new Error(
                    'DELIVERY_CALCULATION'
                ));
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