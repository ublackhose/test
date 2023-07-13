<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


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
