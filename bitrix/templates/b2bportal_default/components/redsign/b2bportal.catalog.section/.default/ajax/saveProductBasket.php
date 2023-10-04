<?php
include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule('highloadblock')) {
    $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
    $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
    $strEntityDataClass = $obEntity->getDataClass();
}

$par = null;

if (CModule::IncludeModule('highloadblock')) {
    $rsData = $strEntityDataClass::getList(array(
        'select' => array('ID','UF_BASKET','UF_PRODUCTS'),
        'order' => array('ID' => 'ASC'),
        'limit' => '50',
    ));
    while ($arItem = $rsData->Fetch()) {
        if($arItem['UF_BASKET'] == Bitrix\Sale\Fuser::getId()){
            $par['ID'] = $arItem['ID'];
            $par['UF_BASKET'] = $arItem['UF_BASKET'];
            $par['UF_PRODUCTS'] = $arItem['UF_PRODUCTS'];
        }
    }
}

if($par){
    if (CModule::IncludeModule('highloadblock')) {
        if($par['UF_PRODUCTS']) {
            $res = json_decode($par['UF_PRODUCTS']);
            $check = true;

            foreach ($res as $item) {
                if ($item == $_REQUEST['id']) {
                    $check = false;
                }
            }

            if ($check) {
                array_push($res, $_REQUEST['id']);
                $data = array(
                    "UF_BASKET" => $par['UF_BASKET'],
                    "UF_PRODUCTS" => json_encode($res),
                );
                $result = $strEntityDataClass::update($par['ID'], $data);
            }
        }else{
            $arElementFields = array(
                'UF_BASKET' => Bitrix\Sale\Fuser::getId(),
                'UF_PRODUCTS' => json_encode(array(0=>$_REQUEST['id']))
            );
            $obResult = $strEntityDataClass::update($par['ID'], $arElementFields);
            $ID = $obResult->getID();
            $bSuccess = $obResult->isSuccess();
        }
    }
}
else{

    if (CModule::IncludeModule('highloadblock')) {
    $arElementFields = array(
        'UF_BASKET' => Bitrix\Sale\Fuser::getId(),
        'UF_PRODUCTS' => json_encode(array(0=>$_REQUEST['id']))
    );
    $obResult = $strEntityDataClass::add($arElementFields);
    $ID = $obResult->getID();
    $bSuccess = $obResult->isSuccess();
    }

}