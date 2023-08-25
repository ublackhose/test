<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$skipProps = array_merge([], $arParams['LINES_PROPERTIES']);

$displayProps = array_filter($arResult['DISPLAY_PROPERTIES'], function ($property) use ($skipProps) {
    return !in_array($property['CODE'], $skipProps) && $property['USER_TYPE'] !== 'redsign_custom_filter';
});

foreach ($arResult['PROPERTIES'] as $key => $val) {
    if (stristr($key, "SOPUTSTVUYUSHCHIY_TOVAR")) {
        if ($val['VALUE']) {
            $ar_recomends[] = $val['VALUE'];
        }
    }
}


$ar_rec_prod = null;
foreach ($ar_recomends as $recomend) {
    $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = array(
        "IBLOCK_ID" => 5,
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "PROPERTY_CML2_ARTICLE" => strval($recomend)
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $ar_rec_prod[] = CCatalogProduct::GetByIDEx($arFields['ID']);
    }
}

if (!$ar_rec_prod) {
    return;
}


?>


<?

$portlet = new Portlet();

$portlet->head(
    new Portlet\Head(function () {
        /** @var Portlet\Head $this */
        $this->title(function () {
            echo "Сопутствующие товары";
        });
    })
);


$body = $portlet->body(function () use ($ar_rec_prod, $arResult) {
    if ($ar_rec_prod) {
        ?>

        <div class="vgt-wrap">
            <table class="vgt-table bordered ">
                <thead>
                <tr>

                    <th class="text-nowrap vgt-left-align" style="min-width: auto; width: auto;">
                        <span>Название</span></th>
                    <th class="text-nowrap vgt-left-align" style="min-width: auto; width: auto;">
                        <span>Наличие</span></th>
                    <th class="text-nowrap vgt-left-align " style="min-width: auto; width: auto;"><span>Цена</span></th>
                    <th class="text-nowrap vgt-left-align text-center" style="min-width: auto; width: auto;">
                        <span></span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($ar_rec_prod as $item) {
                    $price = '';
                    foreach ($item['PRICES'] as $PRICE) {
                        if ($PRICE['CURRENCY'] == "RUB") {
                            $price = $PRICE['PRICE'];
                            break;
                        }
                    }


                    ?>
                    <tr class="">
                        <td class="vgt-left-align" data-entity="price-block">
                            <div>
                                <div class="d-flex">
                                    <div class="d-block">
                                        <div class="mb-2">
                        <span class="mr-2">
                            <a href="<?= $item["DETAIL_PAGE_URL"] ?>">
                                <?= $item["NAME"] ?>
                            </a>
                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="vgt-left-align">
        <span>
            <span>
                <a href="#" class="d-inline-block">
                    <span class="kt-badge kt-badge--inline kt-badge--pill text-nowrap kt-badge--<?= $item["PRODUCT"]["QUANTITY"] > 0 ? "warning" : "danger" ?>">
                                                <?
                                                if (!$ar_res["PRODUCT"]["QUANTITY"]) {
                                                    echo "Под заказ";
                                                } else {
                                                    echo $ar_res["PRODUCT"]["QUANTITY"] . "шт";
                                                }
                                                ?>
                    </span>
                </a>
            </span>
        </span>
                        </td>

                        <td class="vgt-left-align">
                            <div><span class="text-nowrap">
        <?= $price ? $price . " ₽" : $price ?>
            </span>
                            </div>
                        </td>

                        <td class="vgt-left-align text-center" data-entity="buttons-block">
                            <div class="product-item-button-container pt-4">
                                <button class="btn btn-primary btn-sm"
                                        onclick="addBasket( <?= $item["ID"] ?>,'<?= $item["NAME"] ?>') ">
                                    <i class="flaticon2-shopping-cart-1 pr-0">
                                    </i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
    };
});

$portlet->render();
