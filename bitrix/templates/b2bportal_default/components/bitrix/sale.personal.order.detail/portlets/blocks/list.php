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

if ($_REQUEST['update'] == "Y") {
    if (!empty($arResult['BASKET'])) {
        $isCollapsed = in_array('list', $arResult['COLLAPSED_BLOCKS']);


        $renderBlock('list', Loc::getMessage('SPOD_ORDER_LIST'), $isCollapsed, function () use (&$arResult) {
            ?>
            <table class="table">
                <thead>
                <tr>

                    <th class="col"><?= Loc::getMessage('SPOD_NAME') ?></th>
                    <th class="col"><?= Loc::getMessage('SPOD_PRICE') ?></th>
                    <?
                    if (strlen($arResult["SHOW_DISCOUNT_TAB"])) {
                        ?>
                        <th class="col"><?= Loc::getMessage('SPOD_DISCOUNT') ?></th>
                        <?
                    }
                    ?>
                    <th class="col"><?= Loc::getMessage('SPOD_QUANTITY') ?></th>

                    <th class="col"><?= Loc::getMessage('SPOD_QUANTITY_ALl') ?></th>
                    <th class="col text-right"><?= Loc::getMessage('SPOD_ORDER_PRICE') ?></th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody id="test">
                <?
                foreach ($arResult['BASKET'] as $basketItem) {
                    $ar_res = CCatalogProduct::GetByID($basketItem['PRODUCT_ID']);
                    $ar_res2 = CCatalogProduct::GetByIDEx($basketItem['PRODUCT_ID']);
                    ?>


                    <tr data-id="<?= $basketItem['PRODUCT_ID'] ?>" data-price="<?= $basketItem['PRICE'] ?>"
                        data-artnumber= <?= $ar_res2['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>><!---->

                        <td class="sale-order-detail-order-item-properties">
                            <div style="max-width: 275px;">
                                <div class="d-flex align-items-center"><!---->
                                    <div class="d-block">
                                        <div class="mb-2"><span class="mr-2"><a
                                                        href="<?= $basketItem['DETAIL_PAGE_URL'] ?>"
                                                        target="_blank"><?= $basketItem['NAME'] ?></a></span>

                                            <!----></div>
                                    </div>
                                </div>
                            </div> <!----> <!----> <!----> <!----></td>


                        <td class="sale-order-detail-order-item-properties text-right"><!----> <!---->
                            <div class="text-nowrap"><?= $basketItem['BASE_PRICE_FORMATED'] ?></div> <!----> <!---->
                        </td>

                        <?
                        if (strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"])) {
                            ?>
                            <td class="sale-order-detail-order-item-properties text-right">
                                <?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?>
                            </td>
                            <?
                        } elseif (strlen($arResult["SHOW_DISCOUNT_TAB"])) {
                            ?>
                            <td class="sale-order-detail-order-item-properties text-right">
                                <strong class="bx-price"></strong>
                            </td>
                            <?
                        }
                        ?>


                        <td class="sale-order-detail-order-item-properties"><!---->
                            <div data-entity="quantity-block"
                                 class="product-amount form-inline d-inline-block mw-100">
                                <div class="form-group">
                                    <div class="input-group flex-nowrap">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="clickMin(this)"
                                                    class="btn btn-outline-secondary btn-sm">
                                                -
                                            </button>
                                        </div>
                                        <input type="number" min="1" max="100" step="1" tabindex="2"
                                               value="<?= $basketItem['QUANTITY'] ?>"
                                               class="product-amount-field form-control form-control-sm">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                                    onclick="clickPlus(this)">+
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!----> <!----> <!---->
                        </td>


                        <!--                    --><?//
                        //                    echo "<pre>";
                        //                    print_r($basketItem);
                        //                    echo "</pre>";
                        //                    ?>
                        <td class="sale-order-detail-order-item-properties text-right">
                            <strong class="bx-quantity"><?= $ar_res['QUANTITY'] ?></strong>
                        </td>


                        <td class="sale-order-detail-order-item-properties text-right"><!----> <!----> <!---->
                            <div class="font-weight-bold text-nowrap sum_price"><?= $basketItem['PRICE'] * $basketItem['QUANTITY'] ?>
                                ₽
                            </div> <!---->
                        </td>


                        <td class="sale-order-detail-order-item-properties text-right"><!----> <!----> <!----> <!---->
                            <div class="dropdown position-static">
                                <a
                                        data-toggle="dropdown"
                                        data-boundary="viewport"
                                        role="button"
                                        href="#"
                                        class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                        aria-expanded="false"><i
                                            class="la la-ellipsis-h"></i></a>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end"
                                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(526px, -200px, 0px);">

                                    <ul class="kt-nav">
                                        <li class="kt-nav__item">


                                            <a onclick="deletetr(this)" data-target="#modalImportFile"
                                               data-toggle="modal"
                                               href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon flaticon2-trash"></i>
                                                <span class="kt-nav__link-text"
                                                      data-id="<?= $basketItem['PRODUCT_ID'] ?>">
                                                    Удалить
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?
                }
                ?>

                </tbody>
            </table>


            <script>
                function deletetr(e) {
                    let cur = e.querySelector("span");
                    let del = document.querySelector("tr[data-id='" + cur.dataset.id + "']");
                    del.remove();
                }
            </script>


            <div class="kt-portlet__body">
                <div class="row">
                    <?
                    global $APPLICATION;
                    $APPLICATION->IncludeComponent(
                        "redsign:b2bportal.catalog.search.article",
                        "addorder",
                        array(
                            "COMPONENT_TEMPLATE" => ".default",
                            "CONVERT_CURRENCY" => "Y",    // Показывать цены в одной валюте
                            "CURRENCY_ID" => "RUB",    // Валюта, в которую будут сконвертированы цены
                            "IBLOCK_ID" => "5",    // Информационный блок
                            "IBLOCK_TYPE" => "catalog",    // Тип информационного блока
                            "OFFERS_PROP_CODE" => "ARTNUMBER",
                            "PRICES" => array(
                                0 => "BASE",
                            ),
                            "PROPS" => "",
                            "PROP_CODE" => "ARTNUMBER"
                        ),
                        false
                    );
                    ?>
                    <div class="col-md-6"><span class="mr-4">или...</span>
                        <?
                        $APPLICATION->IncludeComponent(
                            "redsign:b2bportal.basket.imports",
                            "order_add",
                            array(
                                "IBLOCK_ID" => "5",
                                "PROP_CODE" => "ARTNUMBER",
                                "OFFERS_PROP_CODE" => "ARTNUMBER",
                                "COMPONENT_TEMPLATE" => "order_add",
                                "IBLOCK_TYPE" => "catalog"
                            ),
                            false
                        );
                        ?>
                    </div>
                </div>


            </div>


            <div class="flex">
                <div class="dropdown dropdown-inline">
                    <a href="/exe/?export=xlsx&order=<?= $arResult['ID'] ?>;" role="button" data-toggle="dropdown"
                       aria-expanded="true" class="btn btn-outline-primary dropdown-toggle">
                        Экспорт заказа
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                         style="position: absolute; transform: translate3d(-30px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">

                        <ul class="kt-nav">
                            <li class="kt-nav__item"><a target="_blank" id="export_xls"
                                                        href="/exe/?export=xlsx&order=<?= $arResult['ID'] ?>;"
                                                        class="kt-nav__link"><i
                                            class="kt-nav__link-icon la la-file-text-o"></i> <span
                                            class="kt-nav__link-text text-uppercase">xlsx</span></a></li>
                        </ul>

                    </div>
                </div>


                <div class="d-block">
                    <button id="update-product" class="btn btn-primary btn-sm ">Сохранить изменения</button>
                </div>
            </div>


            <script>
                document.querySelector("#update-product").addEventListener("click", (e) => {
                    let tr_test = document.querySelector("#test").querySelectorAll("tr");
                    let id_order = <?= $arResult['ID'] ?>;


                    let params = new Object;
                    params['products'] = new Object();
                    params['id'] = id_order;


                    if (tr_test.length != 0) {
                        tr_test.forEach(function check(currentValue, index, array) {
                            let quentitys = currentValue.querySelector(".product-amount-field").value;
                            params['products'][index] = {
                                id: currentValue.dataset.id,
                                quantity: quentitys
                            }
                        });

                        $.ajax({
                            url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/sendchange.php',         /* Куда отправить запрос */
                            method: 'post',             /* Метод запроса (post или get) */
                            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                            async: false,
                            data: {action: 'update', params: JSON.stringify(params)},     /* Данные передаваемые в массиве */
                            success: function (data) {
                                // location.href = 'https://r1.mege-alpha.dev.4rome.ru/personal/orders/' + params['id']+'/';
                                console.log(data);
                            }
                        });
                    } else {
                        window.toastr.error("Заказ не может быть пустым");
                    }
                });
            </script>

            <?php
        });

        ?>
        <script>
            function clickPlus(e) {

                console.log(e);
                let cur = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
                let quantity = cur.querySelector(".bx-quantity");


                console.log(quantity);
                console.log(cur);
                if (Number(cur.querySelector(".product-amount-field").value) < Number(quantity.innerHTML)) {


                    cur.querySelector(".product-amount-field").value = Number(cur.querySelector(".product-amount-field").value) + 1;

                    console.log(cur.querySelector(".sum_price"));


                    cur.querySelector(".sum_price").innerHTML = (Number(cur.querySelector(".product-amount-field").value)
                            * Number(cur.dataset.price))
                        + " ₽";
                }
            }

            function clickMin(e) {
                console.log(123);
                let cur = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
                if (cur.querySelector(".product-amount-field").value > 1) {
                    cur.querySelector(".product-amount-field").value = Number(cur.querySelector(".product-amount-field").value) - 1;
                    cur.querySelector(".sum_price").innerHTML = (Number(cur.querySelector(".product-amount-field").value)
                            * Number(cur.dataset.price))
                        + " ₽";
                }
            }

        </script>
        <?php
    }
} else {
    if (!empty($arResult['BASKET'])) {
        $isCollapsed = in_array('list', $arResult['COLLAPSED_BLOCKS']);


        $renderBlock('list', Loc::getMessage('SPOD_ORDER_LIST'), $isCollapsed, function () use (&$arResult) {
            ?>
            <table class="table">
                <thead>
                <tr>

                    <th class="col"><?= Loc::getMessage('SPOD_NAME') ?></th>
                    <th class="col"><?= Loc::getMessage('SPOD_PRICE') ?></th>
                    <?
                    if (strlen($arResult["SHOW_DISCOUNT_TAB"])) {
                        ?>
                        <th class="col"><?= Loc::getMessage('SPOD_DISCOUNT') ?></th>
                        <?
                    }
                    ?>
                    <th class="col"><?= Loc::getMessage('SPOD_QUANTITY') ?></th>

                    <th class="col"><?= Loc::getMessage('SPOD_QUANTITY_ALl') ?></th>
                    <th class="text-right"><?= Loc::getMessage('SPOD_ORDER_PRICE') ?></th>

                </tr>
                </thead>
                <tbody id="test">
                <?
                foreach ($arResult['BASKET'] as $basketItem) {
                    $ar_res = CCatalogProduct::GetByIDEx($basketItem['PRODUCT_ID']);


                    ?>
                    <tr data-id="<?= $basketItem['PRODUCT_ID'] ?>">
                        <td class="sale-order-detail-order-item-properties">
                            <a class="sale-order-detail-order-item-title"
                               href="<?= $basketItem['DETAIL_PAGE_URL'] ?>"><?= htmlspecialcharsbx(
                                    $basketItem['NAME']
                                ) ?></a>

                            <br>
                            <span>
                                Артикул: <?
                                echo $ar_res['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>
                            </span>

                            <?
                            if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS'])) {
                                foreach ($basketItem['PROPS'] as $itemProps) {
                                    ?>
                                    <div class="sale-order-detail-order-item-properties-type"><?= htmlspecialcharsbx(
                                            $itemProps['VALUE']
                                        ) ?></div>
                                    <?
                                }
                            }
                            ?>
                        </td>
                        <td class="sale-order-detail-order-item-properties">
                            <span class="bx-price"><?= $basketItem['BASE_PRICE_FORMATED'] ?></span>
                        </td>

                        <?
                        if (strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"])) {
                            ?>
                            <td class="sale-order-detail-order-item-properties text-right">
                                <?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?>
                            </td>
                            <?
                        } elseif (strlen($arResult["SHOW_DISCOUNT_TAB"])) {
                            ?>
                            <td class="sale-order-detail-order-item-properties text-right">
                                <strong class="bx-price"></strong>
                            </td>
                            <?
                        }
                        ?>


                        <td class="sale-order-detail-order-item-properties">
                            <?= $basketItem['QUANTITY'] ?>&nbsp;
                            <?
                            if (strlen($basketItem['MEASURE_NAME'])) {
                                echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
                            } else {
                                echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
                            }
                            ?>
                        </td>

                        <td class="sale-order-detail-order-item-properties">
                            <span class="bx-price"><?= $ar_res['QUANTITY'] ?></span>
                        </td>


                        <td class="sale-order-detail-order-item-properties text-right">
                            <strong class="bx-price"><?= $basketItem['FORMATED_SUM'] ?></strong>
                        </td>


                    </tr>
                    <?
                }
                ?>
                </tbody>
            </table>


            <div class="d-flex" style="justify-content: space-between;align-content: center;align-items: center;">
                <div class="dropdown dropdown-inline">
                    <a href="/exe/?export=xlsx&order=<?= $arResult['ID'] ?>;" role="button" data-toggle="dropdown"
                       aria-expanded="true" class="btn btn-outline-primary dropdown-toggle">
                        Экспорт заказа
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                         style="position: absolute; transform: translate3d(-30px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">

                        <ul class="kt-nav">
                            <li class="kt-nav__item"><a target="_blank" id="export_xls"
                                                        href="/exe/?export=xlsx&order=<?= $arResult['ID'] ?>;"
                                                        class="kt-nav__link"><i
                                            class="kt-nav__link-icon la la-file-text-o"></i> <span
                                            class="kt-nav__link-text text-uppercase">xlsx</span></a></li>
                        </ul>

                    </div>
                </div>

                <?
                $order = \Bitrix\Sale\Order::load($arResult['ID']);
                $collection = $order->getPropertyCollection();
                $propertyValue = $collection->getItemByOrderPropertyCode("ISAСT");

                //                echo "<pre style='background: #25252d; color:#fff; border-radius:10px;padding:10px'>";
                //                print_r($propertyValue->getValue());
                //                echo "</pre>";

                if ($propertyValue->getValue() && $propertyValue->getValue() != "Y") {
                    ?>
                    <div>
                        <input class="btn btn-primary btn-sm" data-id="<?= $arResult['ID'] ?>"
                               value="Запросить акт сверки" onclick="isact(this)">
                    </div>
                    <?
                } else {
                    echo "Акт сверки запрошен,менеджер прикрепит его к заказу";
                }
                ?>


            </div>


            <style>
                .table th, .table td {
                    padding: 0.55rem;
                }
            </style>

            <script>
                function isact(e) {

                    $.ajax({
                        url: '/bitrix/templates/b2bportal_default/components/bitrix/sale.personal.order.detail/portlets/ajax/isact.php',         /* Куда отправить запрос */
                        method: 'post',
                        asinc: false,/* Метод запроса (post или get) */
                        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
                        data: {id: e.dataset.id},     /* Данные передаваемые в массиве */
                        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
                            window.toastr.success(data);
                            console.log(e.parentNode)
                            e.parentNode.innerHTML = "Акт сверки запрошен,менеджер прикрепит его к заказу";
                        }
                    });
                }
            </script>
            <?php
        });
    }
}

