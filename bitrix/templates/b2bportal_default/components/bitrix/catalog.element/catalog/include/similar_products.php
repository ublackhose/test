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

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

$skipProps = array_merge([], $arParams['LINES_PROPERTIES']);

$displayProps = array_filter($arResult['DISPLAY_PROPERTIES'], function ($property) use ($skipProps) {
    return !in_array($property['CODE'], $skipProps) && $property['USER_TYPE'] !== 'redsign_custom_filter';
});



?>


<?



$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () {
    /** @var Portlet\Head $this */
    $this->title(function () {
        echo "Аналогичные товары";
    });
}));


$body = $portlet->body(function () use ($displayProps,$arResult) {

    $arProp = array("LOGIC" => "OR");
    foreach ($displayProps as $key=>$prop){
        $arProp[] = array("PROPERTY_".$key."_VALUE" => $prop['VALUE']);
    }



    $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter = array(
        "IBLOCK_ID" => $arResult['IBLOCK_ID'],
        'IBLOCK_SECTION_ID'=>$arResult['IBLOCK_SECTION_ID'],
        '!ID'=>$arResult['ID'],
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        $arProp
    );
    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 5), $arSelect);



//    echo "<pre>";
//    print_r($arResult);
//    echo "</pre>";
    if ($res->result->num_rows <=0){
        $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
        $arFilter = array(
            "IBLOCK_ID" => $arResult['IBLOCK_ID'],
            'IBLOCK_SECTION_ID'=>$arResult['IBLOCK_SECTION_ID'],
            '!ID'=>$arResult['ID'],
            "ACTIVE_DATE" => "Y",
            "ACTIVE" => "Y",
        );
        $res = CIBlockElement::GetList(array('sort'=>'asc'), $arFilter, false, array("nPageSize" => 5), $arSelect);

        if ($res->result->num_rows <=0){


            if($arResult['SECTION']['PATH'][0]['ID']){
                $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
                $arFilter = array(
                    "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                    'SECTION_ID'=>$arResult['SECTION']['PATH'][0]['ID'],
                    'INCLUDE_SUBSECTIONS'=> 'Y',
                    '!ID'=>$arResult['ID'],
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y",
                );
                $res = CIBlockElement::GetList(array('sort'=>'asc'), $arFilter, false, array("nPageSize" => 5), $arSelect);
            }else{
                $arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
                $arFilter = array(
                    "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                    '!ID'=>$arResult['ID'],
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y",
                );
                $res = CIBlockElement::GetList(array('sort'=>'asc'), $arFilter, false, array("nPageSize" => 5), $arSelect);
            }
        }
    }


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
while ($ob = $res->GetNextElement()) {

    $arFields = $ob->GetFields();
    $ar_res = CCatalogProduct::GetByIDEx($arFields['ID']);

    foreach ($ar_res['PRICES'] as $PRICE){
        if($PRICE['CURRENCY'] == "RUB"){
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
                            <a href="<?=$ar_res["DETAIL_PAGE_URL"]?>">
                                <?=$ar_res["NAME"]?>
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
                    <span class="kt-badge kt-badge--inline kt-badge--pill text-nowrap kt-badge--<?=$ar_res["PRODUCT"]["QUANTITY"]>0?"warning":"danger"?>">


                        <?
                        if(!$ar_res["PRODUCT"]["QUANTITY"]){
                            echo "Под заказ";
                        }else{
                            echo $ar_res["PRODUCT"]["QUANTITY"]."шт";
                        }
                        ?>

                    </span>
                </a>
            </span>
        </span>
        </td>





        <td class="vgt-left-align">
            <div><span class="text-nowrap">
        <?=$price?$price." ₽":$price?>
            </span>
            </div>
        </td>

        <td class="vgt-left-align text-center" data-entity="buttons-block">
            <div class="product-item-button-container pt-4">
                <button class="btn btn-primary btn-sm"
                        onclick="addBasket( <?=$ar_res["ID"]?>,'<?=$ar_res["NAME"]?>') ">
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
});

$portlet->render();