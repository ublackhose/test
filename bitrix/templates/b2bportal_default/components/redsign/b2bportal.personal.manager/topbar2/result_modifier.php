<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

use Redsign\B2BPortal\Services\Sale\PersonalProfile;

$db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>PersonalProfile::getSelectedProfile()));
$userProfileOrder = [];    

while ($arPropVals = $db_propVals->Fetch()){
    $userProfileOrder[$arPropVals['PROP_CODE']] = $arPropVals;
}

if (!empty($userProfileOrder['INN']) && !empty($userProfileOrder['KPP'])) {
    $res = CIBlockElement::GetList([], [
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ACTIVE" => 'Y',
        "PROPERTY_INNKPP" => $userProfileOrder['INN']['VALUE'] . '-' . $userProfileOrder['KPP']['VALUE']
    ], false, false, []);
    
    
    if ($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields(); // поля элемента
        $arProps = $ob->GetProperties(); // свойства элемента

        $arResult = [
            'DATA' => [
                'ID' => $arFields['ID'],
                'NAME' => $arFields['NAME'],
            ],
            'HAS_MANAGER' => true
        ];

        foreach ($arProps as $key => $value) {
            $arResult['DATA']['PROPS'][$key] = $value['VALUE'];
        }
    }
}

if (!empty($arResult['DATA']))
{
    if (!empty($arResult['DATA']['PROPS']['PHOTO']))
    {
        $arResult['DATA']['PROPS']['PHOTO'] = CFile::GetPath($arResult['DATA']['PROPS']['PHOTO']);
    }

    if (!empty($arResult['DATA']['PROPS']['PHONE_NUMBER']))
    {
        $arResult['DATA']['PROPS']['PHONE_NUMBER_PREPARED'] = preg_replace('/[^0-9\+]/', '', $arResult['DATA']['PROPS']['PHONE_NUMBER']);
    }

    if (!empty($arResult['DATA']['PROPS']['WHATSAPP']))
    {
        $arResult['DATA']['PROPS']['WHATSAPP_PREPARED'] = preg_replace('/[^0-9]/', '', $arResult['DATA']['PROPS']['WHATSAPP']);
    }

    if (!empty($arResult['DATA']['PROPS']['VIBER']))
    {
        $arResult['DATA']['PROPS']['VIBER_PREPARED'] = preg_replace('/[^0-9\+]/', '', $arResult['DATA']['PROPS']['VIBER']);
    }
}