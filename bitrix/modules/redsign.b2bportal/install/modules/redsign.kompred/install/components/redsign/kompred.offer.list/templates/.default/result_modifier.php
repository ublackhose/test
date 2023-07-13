<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$baseCurrency = \Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency(SITE_ID);

if ($arResult['OFFERS']) {
    foreach ($arResult['OFFERS'] as &$offerData) {
        if ($offerData['PRODUCTS']) {
            $offerData['TOTAL_PRICE_FORMATTED'] = \CCurrencyLang::CurrencyFormat(
                $offerData['TOTAL_PRICE'],
                $offerData['PRODUCTS'][0]['CURRENCY']
            );
        } else {
            $offerData['TOTAL_PRICE_FORMATTED'] = \CCurrencyLang::CurrencyFormat(
                $offerData['TOTAL_PRICE'],
                $baseCurrency
            );
        }
    }
}
