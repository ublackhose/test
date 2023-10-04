<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}



$arShipmentSystem = null;
$order = \Bitrix\Sale\Order::load($arResult['ID']);
$shipmentCollection = $order->getShipmentCollection();
foreach ($shipmentCollection as $shipment) {
    $shipment_id = $shipment->getId();
    //пропускаем системные
    if ($shipment->isSystem()) {
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


        foreach ($shipmentItemCollection as $item) {
            //объект Товара в корзине Отгрузки
            $basketItem = $item->getBasketItem();

            //не учитываем товары, которые нельзя купить или которые отложены
            if (!$basketItem->canBuy() || $basketItem->isDelay()) {
                continue;
            }

            $arItem = array(
                'PRODUCT_ID' => $basketItem->getProductId(),
                'NAME' => $basketItem->getField('NAME'),
                'PRICE' => $basketItem->getPrice(),    // за единицу
                'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
                'QUANTITY' => $basketItem->getQuantity(),
                'WEIGHT' => $basketItem->getWeight(),
            );
            $arShipmentSystem['ID'] = $shipment_id;
            $arShipmentSystem['BASKET'][$arItem['PRODUCT_ID']] = $arItem;
        }

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


    foreach ($shipmentItemCollection as $item) {
        //объект Товара в корзине Отгрузки
        $basketItem = $item->getBasketItem();

        //не учитываем товары, которые нельзя купить или которые отложены
        if (!$basketItem->canBuy() || $basketItem->isDelay()) {
            continue;
        }

        $arItem = array(
            'PRODUCT_ID' => $basketItem->getProductId(),
            'NAME' => $basketItem->getField('NAME'),
            'PRICE' => $basketItem->getPrice(),    // за единицу
            'FINAL_PRICE' => $basketItem->getFinalPrice(),  // сумма
            'QUANTITY' => $basketItem->getQuantity(),
            'WEIGHT' => $basketItem->getWeight(),
        );
        $arShipments[$shipment_id]['BASKET'][$arItem['PRODUCT_ID']] = $arItem;
    }
    foreach ($arResult['SHIPMENT'] as $key => $s) {
        $arResult['SHIPMENT'][$key]['BASKET'] = $arShipments[$s['ID']]['BASKET'];
    }
}



$result = \Bitrix\Sale\Delivery\Services\Table::getList(array(
    'filter' => array('ACTIVE' => 'Y'),
));


while ($delivery = $result->fetch()) {
    $arDiliverys[$delivery['ID']] = array('NAME' => $delivery['NAME']);
}

foreach ($shipmentCollection as $shipment) {
    $enum = $shipment->getDelivery()->getExtraServices()->getItems();
}


if (!empty($enum[4])) {
    $params = $enum[4]->getParams();
}

if ($arDiliverys[23]) {
    $arDiliverys[23] = null;
    if (!empty($params)) {
        foreach ($params['PRICES'] as $key => $param) {
            $arDiliverys[23][] = array('ID' => $key, 'NAME' => "Major " . $param['TITLE']);
        }
    }
}


if (!count($arResult['SHIPMENT'])) {
//    echo "У вас нет нечего, вы бомж";
} else {

    ?>

    <div class="row">
        <div class="col-12">
            <?php include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/blocks/order.php'; ?>
        </div>
    </div>

    <?

    foreach ($arResult['SHIPMENT'] as $shipment) {
        ?>
        <div id="<?= $shipment['ACCOUNT_NUMBER'] ?>" class="kt-portlet kt-portlet--draggable"
             data-content="sale_order_detail_block_payment">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">Товары отгрузки
                        №<?= $shipment['ACCOUNT_NUMBER'] ?> <?= $shipment['DELIVERY_NAME'] ?></h3>
                </div>

                <div class="dropdown position-static show"><a data-toggle="dropdown" data-boundary="viewport"
                                                              role="button" href="#" class="btn btn-default disabled"
                                                              aria-expanded="true"><i class="flaticon2-soft-icons"></i>Действия
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                         style="position: absolute; transform: translate3d(393px, 48px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <ul class="kt-nav">

                            <?php
                            foreach ($arResult['SHIPMENT'] as $s) {
                                if ($s['ID'] != $shipment['ID']) {
                                    ?>

                                    <li class="kt-nav__item">
                                        <a data-target="#modalImportFile"
                                           data-order-id = "<?=$arResult['ID']?>"
                                           data-shipment-id-to = "<?=$s['ID']?>"
                                           data-shipment-id-from = "<?=$shipment['ID']?>"
                                           onclick="moveBasketItems(this)"
                                           data-toggle="modal" href="#"
                                           class="kt-nav__link">
                                            <i class="kt-nav__link-icon flaticon2-delivery-truck"></i>
                                            <span class="kt-nav__link-text">Переместить в
                                                    <span class="text-decoration-underline"
                                                          href="#<?= $s['ACCOUNT_NUMBER'] ?>">отгрузка №<?= $s['ACCOUNT_NUMBER'] ?> <?= $s['DELIVERY_NAME'] ?></span>
                                            </span>
                                        </a>
                                    </li>

                                    <?php
                                }
                            } ?>

                        </ul>
                    </div>
                </div>

            </div>

            <div class="collapse show" id="sale_order_detail_block_payment">
                <div class="kt-portlet__body" style="padding: 0px">


                    <?php if ($shipment['BASKET']) { ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="vgt-checkbox-col" style="width: 60px; padding: 0px 11px;"><label
                                            class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                        <input onclick="checkAll(this)" type="checkbox"> <span>

                                        </span>
                                    </label>
                                </th>
                                <th class="text-nowrap vgt-left-align can-sorting" style=" padding: 16px 25px;"><span>Наименование</span>
                                </th>
                                <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;">
                                    <span>Цена</span></th>
                                <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;"><span>Количество</span>
                                </th>
                                <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;">
                                    <span>Сумма</span></th>
                                <th class="text-nowrap vgt-left-align"><span></span></th>
                            </tr>
                            </thead>
                            <tbody id="test">
                            <?
                            foreach ($shipment['BASKET'] as $item) {
                                ?>
                                <tr class=" vgt-row--selected">
                                    <th class="vgt-checkbox-col">
                                        <label class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                            <input class="prod" data-id-product = "<?=$item['PRODUCT_ID']?>" onclick="check(this)" type="checkbox">
                                            <span></span>
                                        </label>
                                    </th>


                                    <td class="vgt-left-align">
                                        <div class="text-nowrap"><?= $item['NAME'] ?></div>
                                    </td>

                                    <td class="vgt-right-align">
                                        <div class="text-nowrap"><?= $item['PRICE'] ?> ₽</div>
                                    </td>

                                    <td class="vgt-right-align">
                                        <?= $item['QUANTITY'] ?>
                                    </td>

                                    <td class="vgt-right-align">
                                        <?= $item['FINAL_PRICE'] ?> ₽
                                    </td>

                                    <td class="vgt-left-align">
                                        <div class="dropdown">
                                            <a data-toggle="dropdown" data-boundary="viewport" role="button"
                                               href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                <i class="la la-ellipsis-h">

                                                </i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="kt-nav">
                                                    <?
                                                    foreach ($arResult['SHIPMENT'] as $s) {
                                                        if ($s['ID'] != $shipment['ID']) {
                                                            ?>
                                                            <li class="kt-nav__item">
                                                                <a data-target="#modalImportFile"
                                                                   onclick="moveBasketItem(this)"
                                                                   data-order-id = "<?=$arResult['ID']?>"
                                                                   data-id-product = "<?=$item['PRODUCT_ID']?>"
                                                                   data-shipment-id-to = "<?=$s['ID']?>"
                                                                   data-shipment-id-from = "<?=$shipment['ID']?>"
                                                                   data-toggle="modal"
                                                                   href="#" class="kt-nav__link">
                                                                    <i class="kt-nav__link-icon
                                                                    flaticon2-delivery-truck"></i>
                                                                    <span class="kt-nav__link-text">Переместить в
                                                    <span class="text-decoration-underline"
                                                          href="#<?= $s['ACCOUNT_NUMBER'] ?>">отгрузка №<?= $s['ACCOUNT_NUMBER'] ?> <?= $s['DELIVERY_NAME'] ?></span>
                                            </span>
                                                                </a>
                                                            </li>
                                                            <?
                                                        }
                                                    } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <?
                            } ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>

                        <h6>
                            Товары в данной отгрузки отсутствуют.
                        </h6>
                        <?
                    } ?>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-portlet__foot-wrapper">
                    <div class="kt-portlet__foot-info"></div>
                    <div class="kt-portlet__foot-toolbar">
                        <div class="dropdown"><a data-toggle="dropdown" data-boundary="viewport" role="button"
                                                 href="#"
                                                 class="btn btn-default disabled"><i
                                        class="flaticon2-soft-icons"></i>
                                Действия
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="kt-nav" disabled="disabled">


                                    <?
                                    foreach ($arResult['SHIPMENT'] as $s) {
                                        if ($s['ID'] != $shipment['ID']) {
                                            ?>
                                            <li class="kt-nav__item">
                                                <a
                                                        data-order-id = "<?=$arResult['ID']?>"
                                                        data-shipment-id-to = "<?=$s['ID']?>"
                                                        data-shipment-id-from = "<?=$shipment['ID']?>"
                                                        onclick="moveBasketItems(this)"
                                                   data-target="#modalImportFile" data-toggle="modal"
                                                   href="#" class="kt-nav__link">
                                                    <i class="kt-nav__link-icon flaticon2-delivery-truck"></i>
                                                    <span class="kt-nav__link-text">Переместить в
                                                    <span class="text-decoration-underline"
                                                          href="#<?= $s['ACCOUNT_NUMBER'] ?>">отгрузка №<?= $s['ACCOUNT_NUMBER'] ?> <?= $s['DELIVERY_NAME'] ?></span>
                                            </span>
                                                </a>
                                            </li>

                                            <?
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
<!--    $arShipmentSystem-->

    <?php
}


if($arShipmentSystem){
    ?>
<div id="<?= $shipment['ACCOUNT_NUMBER'] ?>" class="kt-portlet kt-portlet--draggable"
     data-content="sale_order_detail_block_payment">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">Товары без отгрузки</h3>
        </div>

        <div class="dropdown position-static show"><a data-toggle="dropdown" data-boundary="viewport"
                                                      role="button" href="#" class="btn btn-default disabled"
                                                      aria-expanded="true"><i class="flaticon2-soft-icons"></i>Действия
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                 style="position: absolute; transform: translate3d(393px, 48px, 0px); top: 0px; left: 0px; will-change: transform;">
                <ul class="kt-nav">

                    <?php
                    foreach ($arResult['SHIPMENT'] as $s) {
                            ?>

                            <li class="kt-nav__item">
                                <a data-target="#modalImportFile"
                                   data-order-id = "<?=$arResult['ID']?>"
                                   data-shipment-id-to = "<?=$s['ID']?>"
                                   data-shipment-id-from = "<?=$arShipmentSystem['ID']?>"
                                   onclick="moveBasketItems(this)"
                                   data-toggle="modal" href="#"
                                   class="kt-nav__link">
                                    <i class="kt-nav__link-icon flaticon2-delivery-truck"></i>
                                    <span class="kt-nav__link-text">Переместить в
                                                    <span class="text-decoration-underline"
                                                          href="#<?= $s['ACCOUNT_NUMBER'] ?>">отгрузка №<?= $s['ACCOUNT_NUMBER'] ?> <?= $s['DELIVERY_NAME'] ?></span>
                                            </span>
                                </a>
                            </li>

                            <?php
                    } ?>

                </ul>
            </div>
        </div>
    </div>


        <div class="collapse show" id="sale_order_detail_block_payment">
            <div class="kt-portlet__body" style="padding: 0px">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="vgt-checkbox-col" style="width: 60px; padding: 0px 11px;"><label
                                    class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                <input onclick="checkAll(this)" type="checkbox"> <span>

                                        </span>
                            </label>
                        </th>
                        <th class="text-nowrap vgt-left-align can-sorting" style=" padding: 16px 25px;"><span>Наименование</span>
                        </th>
                        <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;">
                            <span>Цена</span></th>
                        <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;"><span>Количество</span>
                        </th>
                        <th class="text-nowrap vgt-right-align can-sorting" style=" padding: 16px 25px;">
                            <span>Сумма</span></th>
                        <th class="text-nowrap vgt-left-align"><span></span></th>
                    </tr>
                    </thead>
                    <tbody id="test">
                    <?
                    foreach ($arShipmentSystem['BASKET'] as $item) {
                        ?>
                        <tr class=" vgt-row--selected">
                            <th class="vgt-checkbox-col">
                                <label class="vgt-checkbox-label kt-checkbox kt-checkbox--single kt-checkbox--solid">
                                    <input class="prod" data-id-product = "<?=$item['PRODUCT_ID']?>" onclick="check(this)" type="checkbox">
                                    <span></span>
                                </label>
                            </th>


                            <td class="vgt-left-align">
                                <div class="text-nowrap"><?= $item['NAME'] ?></div>
                            </td>

                            <td class="vgt-right-align">
                                <div class="text-nowrap"><?= $item['PRICE'] ?> ₽</div>
                            </td>

                            <td class="vgt-right-align">
                                <?= $item['QUANTITY'] ?>
                            </td>

                            <td class="vgt-right-align">
                                <?= $item['FINAL_PRICE'] ?> ₽
                            </td>

                            <td class="vgt-left-align">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" data-boundary="viewport" role="button"
                                       href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                        <i class="la la-ellipsis-h">

                                        </i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="kt-nav">
                                            <?
                                            foreach ($arResult['SHIPMENT'] as $s) {
                                                    ?>
                                                    <li class="kt-nav__item">
                                                        <a data-target="#modalImportFile"
                                                           onclick="moveBasketItem(this)"
                                                           data-order-id = "<?=$arResult['ID']?>"
                                                           data-id-product = "<?=$item['PRODUCT_ID']?>"
                                                           data-shipment-id-to = "<?=$s['ID']?>"
                                                           data-shipment-id-from = "<?=$arShipmentSystem['ID']?>"
                                                           data-toggle="modal"
                                                           href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon
                                                                    flaticon2-delivery-truck"></i>
                                                            <span class="kt-nav__link-text">Переместить в
                                                    <span class="text-decoration-underline"
                                                          href="#<?= $s['ACCOUNT_NUMBER'] ?>">отгрузка №<?= $s['ACCOUNT_NUMBER'] ?> <?= $s['DELIVERY_NAME'] ?></span>
                                            </span>
                                                        </a>
                                                    </li>
                                                    <?
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>


</div>


    <?php

}
?>

<style>
    .vgt-checkbox-col {
        padding: 0.75em 16px;
    }

    .kt-portlet.kt-portlet--draggable .kt-portlet__head {
        align-items: center;
    }
</style>


<script>
    function checkAll(e) {
        if ($(e).is(':checked')) {
            $(e).parents("table").find("input[type=checkbox]").prop('checked', true);
            $(e).parents(".kt-portlet.kt-portlet--draggable").find(".btn.btn-default").removeClass( "disabled" );
        } else {
            $(e).parents("table").find("input[type=checkbox]").prop('checked', false);
            $(e).parents(".kt-portlet.kt-portlet--draggable").find(".btn.btn-default").addClass( "disabled" );
        }
    }

    function check(e){
        let check = false;
        $(e).parents("tbody").find("input").each(function( index ) {
            if($( this ).is(':checked')){
                check = true;
            }
        });

        if(check){
            $(e).parents(".kt-portlet.kt-portlet--draggable").find(".btn.btn-default").removeClass( "disabled" );
        }else {
            $(e).parents(".kt-portlet.kt-portlet--draggable").find(".btn.btn-default").addClass( "disabled" );
        }
    }


   function moveBasketItem(e){
       $.ajax({
           url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/moveBasketItem.php',
           method: 'post',
           dataType: 'html',
           data: {order_id:$(e).data("order-id"),id_product: $(e).data("id-product"),"shipment-id-to":$(e).data("shipment-id-to"),"shipment-id-from":$(e).data("shipment-id-from")},
           success: function(data){
               console.log(data);
               // location.reload();
           }
       });
   }


    function moveBasketItems(e){

        console.log( );

        let arr = [];

        $(e).parents(".kt-portlet").find('input.prod:checkbox:checked').each(function(index){
            arr[index] = $(this).data("id-product");
        });


        $.ajax({
            url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/moveBasketItems.php',
            method: 'post',
            dataType: 'html',
            data: {order_id:$(e).data("order-id"),id_products: JSON.stringify(arr),"shipment-id-to":$(e).data("shipment-id-to"),"shipment-id-from":$(e).data("shipment-id-from")},
            success: function(data){
                location.reload();
            }
        });
    }



</script>
