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


$order = \Bitrix\Sale\Order::load($arResult['ID']);
$shipmentCollection = $order->getShipmentCollection();


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


if ($_REQUEST['update'] == "Y") {
    if (count($arResult['SHIPMENT'])) {
        $isCollapsed = in_array('shipment', $arResult['COLLAPSED_BLOCKS']);
        $renderBlock(
            'shipment',
            Loc::getMessage('SPOD_ORDER_SHIPMENT'),
            $isCollapsed,
            function () use ($arDiliverys, &$arResult, &$arParams) {
                $shipmentCount = count($arResult['SHIPMENT']);
                $index = 0;

//        print_r($arResult['SHIPMENT']);

                foreach ($arResult['SHIPMENT'] as $shipment) {
                    ?>

                    <div style="display: flex;justify-content: space-between;"
                         class="<?= ($index < $shipmentCount - 1 ? ' mb-5' : '') ?>">
                        <div>
                            <h6>
                                <?php
                                //change date
                                if (!strlen($shipment['PRICE_DELIVERY_FORMATED'])) {
                                    $shipment['PRICE_DELIVERY_FORMATED'] = 0;
                                }
                                $shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT') . " " . Loc::getMessage(
                                        'SPOD_NUM_SIGN'
                                    ) . $shipment["ACCOUNT_NUMBER"];
                                if ($shipment["DATE_DEDUCTED"]) {
                                    $shipmentRow .= " " . Loc::getMessage(
                                            'SPOD_FROM'
                                        ) . " " . $shipment["DATE_DEDUCTED"]->format(
                                            $arParams['ACTIVE_DATE_FORMAT']
                                        );
                                }
                                $shipmentRow = htmlspecialcharsbx($shipmentRow);
                                $shipmentRow .= ", " . Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
                                        '#PRICE_DELIVERY#' => $shipment['PRICE_DELIVERY_FORMATED']
                                    ));
                                echo $shipmentRow;
                                ?>
                            </h6>
                            <!--                            <div class="delete-otgruzka">-->
                            <!--                                <input class="">-->
                            <!--                            </div>-->
                            <?php
                            if (strlen($shipment["DELIVERY_NAME"])) {
                                ?>
                                <div class="d-block">
                                    <?= Loc::getMessage('SPOD_ORDER_DELIVERY') ?>: <?= htmlspecialcharsbx(
                                        $shipment["DELIVERY_NAME"]
                                    ) ?>
                                </div>
                                <?
                            }
                            ?>
                            <div class="d-block">
                                <?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS') ?>:
                                <?= htmlspecialcharsbx($shipment['STATUS_NAME']) ?>
                            </div>
                            <?
                            if (strlen($shipment['TRACKING_NUMBER'])) {
                                ?>
                                <div class="d-blcok">
                                    <?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:
                                    <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                                </div>
                                <?
                            }
                            ?>
                            <?php
                            if (strlen($shipment['TRACKING_URL'])) {
                                ?>
                                <div class="d-block">
                                    <a href="<?= $shipment['TRACKING_URL'] ?>">
                                        <?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?>
                                    </a>
                                </div>
                                <?
                            }
                            ?>

                        </div>


                        <!--<div class="d-block mt-4 ">
                            <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="dropdown"
                               data-entity="change-delivery" aria-expanded="true">
                                Сменить способ доставки
                            </a>

                            <div class="dropdown-menu " x-placement="bottom-start" data-entity="delivery-list"
                                 style="position: absolute; transform: translate3d(10px, 91px, 0px); top: 0px;
                                 left: 0px; will-change: transform;">
                                <ul class="kt-nav" data-id="delivery">


                                    <?/*
                                    foreach ($arDiliverys as $key => $item) {
                                        */ ?>


                                        <?/*
                                        if ($key == 23) {
                                            foreach ($arDiliverys[23] as $k => $i) {
                                                */ ?>

                                                <li onclick="updateDilivery(this)" class="kt-nav__item" data-entity="delivery" data-delivery-id="<?/*= $key */ ?>">
                                                    <a href="#" class="kt-nav__link">
                                                        <span class="kt-nav__link-text"><?/*=$i['NAME']*/ ?></span>
                                                    </a>
                                                </li>

                                                <?/*
                                            }
                                        }else{
                                        */ ?>


                                        <li onclick="updateDilivery(this)" class="kt-nav__item" data-entity="delivery" data-delivery-id="<?/*= $key */ ?>">
                                            <a href="#" class="kt-nav__link">
                                                <span class="kt-nav__link-text"><?/*=$item['NAME']*/ ?></span>
                                            </a>
                                        </li>

                                        <?/*
                                        }
                                    }
                                    */ ?>



                                </ul>
                            </div>
                        </div>-->
                    </div>
                    <?php
                    $index++;
                }
            }
        );
    } ?>

    <?php
}  else
{

    if (count($arResult['SHIPMENT'])) {
        $isCollapsed = in_array('shipment', $arResult['COLLAPSED_BLOCKS']);
        $renderBlock(
            'shipment',
            Loc::getMessage('SPOD_ORDER_SHIPMENT'),
            $isCollapsed,
            function () use (&$arResult, &$arParams) {
                $shipmentCount = count($arResult['SHIPMENT']);
                $index = 0;

//        print_r($arResult['SHIPMENT']);

                foreach ($arResult['SHIPMENT'] as $shipment) {
                    ?>

                    <div id="shipment_<?= $shipment['ID'] ?>" style="display: flex;justify-content: space-between;"
                         class="<?= ($index < $shipmentCount - 1 ? ' mb-5' : '') ?>">
                        <div>
                            <h6>
                                <?php
                                //change date
                                if (!strlen($shipment['PRICE_DELIVERY_FORMATED'])) {
                                    $shipment['PRICE_DELIVERY_FORMATED'] = 0;
                                }
                                $shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT') . " " . Loc::getMessage(
                                        'SPOD_NUM_SIGN'
                                    ) . $shipment["ACCOUNT_NUMBER"];
                                if ($shipment["DATE_DEDUCTED"]) {
                                    $shipmentRow .= " " . Loc::getMessage(
                                            'SPOD_FROM'
                                        ) . " " . $shipment["DATE_DEDUCTED"]->format(
                                            $arParams['ACTIVE_DATE_FORMAT']
                                        );
                                }
                                $shipmentRow = htmlspecialcharsbx($shipmentRow);
                                $shipmentRow .= ", " . Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
                                        '#PRICE_DELIVERY#' => $shipment['PRICE_DELIVERY_FORMATED']
                                    ));
                                echo $shipmentRow;
                                ?>
                            </h6>


                            <?php
                            if (strlen($shipment["DELIVERY_NAME"])) {
                                ?>
                                <div class="d-block">
                                    <?= Loc::getMessage('SPOD_ORDER_DELIVERY') ?>: <?= htmlspecialcharsbx(
                                        $shipment["DELIVERY_NAME"]
                                    ) ?>
                                </div>
                                <?
                            }
                            ?>
                            <div class="d-block">
                                <?= Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS') ?>:
                                <?= htmlspecialcharsbx($shipment['STATUS_NAME']) ?>
                            </div>

                            <?


                            ?>
                            <!--                            --><?//
                            //                            if (strlen($shipment['TRACKING_NUMBER'])) {
                            //                                ?>
                            <!--                                <div class="d-blcok">-->
                            <!--                                    -->
                            <?//= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?><!--:-->
                            <!--                                    --><?//= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                            <!--                                </div>-->
                            <!--                                --><?//
                            //                            }
                            //                            ?>
                            <!--                            --><?php
                            //                            if (strlen($shipment['TRACKING_URL'])) {
                            //                                ?>
                            <!--                                <div class="d-block">-->
                            <!--                                    <a href="-->
                            <?//= $shipment['TRACKING_URL'] ?><!--">-->
                            <!--                                        --><?//= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?>
                            <!--                                    </a>-->
                            <!--                                </div>-->
                            <!--                                --><?//
                            //                            }
                            //                            ?>



                            <?php
                            if ($arResult['PAYED'] && $arResult['PAYED'] == "Y") {
                                $order = \Bitrix\Sale\Order::load($arResult['ID']);


                                $propertyCollection = $order->getPropertyCollection();
                                $property = $propertyCollection->getItemByOrderPropertyCode("DATE_DELIVERY");
                                $date_cur = $property->getValue();
                                $date = substr(date('d.m.Y', strtotime($order->date . '1 day')), 0, 10);
                                $property = $propertyCollection->getItemByOrderPropertyCode("APPROVAL_DATE");
                                $sogl = $property->getValue();


                                $property = $propertyCollection->getItemByOrderPropertyCode("TRACKING_URL");
                                $tu = $property->getValue();

                                $property = $propertyCollection->getItemByOrderPropertyCode("TRACKING_NUMBER");
                                $tn = $property->getValue();

                            if (strlen($tn)) {
                                ?>
                                <div class="d-blcok mt-4">
                                    <?= Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER') ?>:
                                    <?= htmlspecialcharsbx($tn) ?>
                                </div>
                            <?
                            }
                            if (strlen($tu)) {
                            ?>
                                <div class="d-block mb-4">
                                    <a href="<?= $tu ?>">
                                        <?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING') ?>
                                    </a>
                                </div>
                            <?
                            }



                            if ($date_cur && $date >= $date_cur){
                            ?>

                            <?
                            if ($date_cur && $sogl != 'Y'){
                            ?>

                                <div class="d-block">
                                    Дата забора/отправки: <?= $date_cur ?>
                                </div>


                                <div class="row" style="margin-top: 10px">
                                    <input id="send-date" class="btn btn-primary btn-sm" type="button"
                                           value="Отправить товары">
                                </div>

                                <script>
                                    document.querySelector("#send-date").addEventListener("click", (event) => {
                                        $.ajax({
                                            url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/savedate.php',         /* Куда отправить запрос */
                                            method: 'post',             /* Метод запроса (post или get) */
                                            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                                            data: {ID: <?=$arResult['ID']?>},     /* Данные передаваемые в массиве */
                                            success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                                                console.log(data);
                                                window.location.reload()
                                            }
                                        });

                                    });
                                </script>

                            <?
                            }else{
                            ?>
                                <div class="d-block">
                                    Дата забора/отправки: <?= $date_cur ?>
                                </div>
                                <div class="d-block">
                                    Статус согласование даты: <span
                                            class="kt-badge kt-badge--inline kt-badge--pill kt-badge--success">Согласован</span>
                                </div>
                            <?
                            } ?>

                            <?
                            }else{
                            ?>
                            <?
                            if ($date_cur){
                            ?>

                                <div class="d-block">
                                    Дата забора/отправки: <?= $date_cur ?>
                                </div>
                                <?
                            } ?>




                                <!--    #595d6e-->
                                <?php
                            }
                            }

                            ?>


                        </div>

                        <?php
                        if (($arResult['STATUS_ID'] == 'N' || $arResult['STATUS_ID'] == 'M') && $arResult["PAYED"] != "Y") {
                            ?>



                            <div class="delite-shipment">
                                <input onclick="deleteShipment(<?= $shipment['ID'] ?>, <?= $arResult['ID'] ?>)"
                                       class="btn btn-primary btn-sm" value="Удалить отгрузку">
                            </div>

                            <?php
                        }
                        ?>
                    </div>

                    <?
                    $result = \Bitrix\Sale\Delivery\Services\Table::getList(array(
                        'filter' => array('ACTIVE' => 'Y'),
                    ));
                    $arDiliverys = null;
                    while ($delivery = $result->fetch()) {
                        $arDiliverys[] = $delivery;
                    }


                    ?>


                    <?php
                    $index++;
                }


                if (($arResult['STATUS_ID'] == 'N' || $arResult['STATUS_ID'] == 'M') && $arResult["PAYED"] != "Y") {



                    ?>


                    <div class="d-block mt-4">
                        <div class="add-shipment">
                            <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="dropdown"
                               id="<?= $shipment['ID'] ?>" data-entity="change-payment">Добавить отгрузку</a>

                            <div class="dropdown-menu" data-entity="payment-list"
                                 style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(92px, 91px, 0px);">
                                <ul class="kt-nav">


                                    <? foreach ($arDiliverys as $dilivery) {
                                        if ($dilivery['ID'] == 4) {
                                            continue;
                                        }
                                        if ($dilivery['CODE'] == 'pecom') {
                                            continue;
                                        } elseif (str_contains($dilivery['CODE'], 'pecom')) {
                                            $dilivery['NAME'] = "ПЭК " . $dilivery['NAME'];
                                        }
                                        ?>
                                        <li class="kt-nav__item" onclick="addShipment(this)"
                                            data-id="<?= $arResult['ID'] ?>" data-shipment-id="<?= $dilivery['ID'] ?>">
                                            <a class="kt-nav__link">
                                                <span class="kt-nav__link-text"><?= $dilivery['NAME'] ?></span>
                                            </a>
                                        </li>
                                        <?
                                    } ?>


                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;justify-content: space-between;
    padding: 0px 6px;">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date'>
                                    <label>
                                        Выбрать желаемую дату забора/отправки
                                    </label>
                                    <div class="d-flex send-date-form">
                                        <form id="form-date" onsubmit="return false;">
                                            <input type="text" id="date" name="from" class="form-control">
                                            <input type="submit" name="submit"
                                                   value="Сохранить желаемую дату"
                                                   class="btn btn-primary btn-sm">
                                        </form>
                                    </div>
                                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar">
                            </span>
                        </span>
                                </div>
                            </div>
                        </div>


                        <script>


                            document.querySelector("#form-date").addEventListener("submit", (event) => {


                                if (document.querySelector("#date").value) {
                                    $.ajax({
                                        url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/datechange.php',         /* Куда отправить запрос */
                                        method: 'post',             /* Метод запроса (post или get) */
                                        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                                        data: {
                                            ID: <?=$arResult['ID']?>,
                                            DATE: document.querySelector("#date").value
                                        },     /* Данные передаваемые в массиве */
                                        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                                            window.toastr.success("Дата отправлена на расмотрение менеджеру");
                                        }
                                    });
                                }
                                return false;

                            });

                        </script>


                        <script>
                            $(function () {
                                var dateFormat = "mm/dd/yy",
                                        from = $("#date")
                                                .datepicker({
                                                    defaultDate: "+1w",
                                                    changeMonth: true,
                                                    numberOfMonths: 1,
                                                    minDate: new Date(),
                                                })
                                                .on("change", function () {
                                                    to.datepicker("option", "minDate", getDate(this));
                                                }),
                                        to = $("#to").datepicker({
                                            defaultDate: "+1w",
                                            changeMonth: true,
                                            numberOfMonths: 1
                                        })
                                                .on("change", function () {
                                                    from.datepicker("option", "maxDate", getDate(this));
                                                });

                                function getDate(element) {
                                    var date;
                                    try {
                                        date = $.datepicker.parseDate(dateFormat, element.value);
                                    } catch (error) {
                                        date = null;
                                    }

                                    return date;
                                }
                            });

                        </script>

                        <div class="update-shipment">
                            <a href="/personal/orders/<?= $arResult['ID'] ?>/?poshol_von=<?= $arResult['ID'] ?>" class="btn btn-primary btn-sm" >Изменить состав отгрузок</a>
                        </div>
                    </div>
                    <?php



                }
            }
        );
    } ?>

    <?php
}

?>

<script>
    function deleteShipment(id, id_order) {

        $.ajax({
            url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/deleteshipment.php',         /* Куда отправить запрос */
            method: 'post',             /* Метод запроса (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {
                id_order: id_order,
                id: id
            },     /* Данные передаваемые в массиве */
            success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                window.toastr.success(data);
                $("#shipment_" + id).remove();
            }
        });

    }


    function updateShipment(id, id_order) {
        window.location.reload("http://r1.mege-alpha.dev.4rome.ru/personal/orders/200/?poshol_von=123");
    }

    function addShipment(event) {
        console.log(event);

        console.log(event.dataset);

        $.ajax({
            url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/addshipment.php',         /* Куда отправить запрос */
            method: 'post',             /* Метод запроса (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {
                id_order: event.dataset.id,
                id: event.dataset.shipmentId
            },     /* Данные передаваемые в массиве */
            success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                window.toastr.success(data);
                // $( "#shipment_"+id).remove();
                // console.log(data);
                window.location.reload();
            }
        });

    }


</script>


<script>
    $('.ui-icon-circle-triangle-w').html("«");
    $('.ui-icon-circle-triangle-e').html("»");
</script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<!--<script>
function updateDilivery(e){
    id_dil = e.dataset.deliveryId;
    let id_order = <?
/*= $arResult['ID'] */ ?>;



    let params = new Object;
    params['id'] = id_order;
    params['id_delivery'] = id_dil;
    params['name_delivery'] = e.querySelector("span").innerHTML;
    $.ajax({
        url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/sendchange.php',         /* Куда отправить запрос */
        method: 'post',             /* Метод запроса (post или get) */
        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        async: false,
        data: {action: 'update_dilivery', params: JSON.stringify(params)},     /* Данные передаваемые в массиве */
        success: function(data){
            console.log(data);
        }
    });


}
</script>-->