<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");


$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_KOLICHESTVO_V_UPAKOVKE");
$arFilter = Array("IBLOCK_ID"=>IntVal(5), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

\Bitrix\Main\Loader::includeModule('catalog');

while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    if($arFields['PROPERTY_KOLICHESTVO_V_UPAKOVKE_VALUE']){
            $db_measure = CCatalogMeasureRatio::getList(
                array(),
                $arFilter = array('PRODUCT_ID' => $arFields['ID']),
                false,
                false
            );
            $ar_measure = $db_measure->Fetch();
            CCatalogMeasureRatio::update($ar_measure['ID'], array("RATIO" => $arFields['PROPERTY_KOLICHESTVO_V_UPAKOVKE_VALUE']));
    }

}




?>