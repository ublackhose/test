<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\DI;
use \Redsign\B2BPortal\Spreadsheet\PhpSpreadsheetWriter;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixBasketComponent $component
 * @var array $arParams
 * @var array $arResult
 */


if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$APPLICATION->RestartBuffer();


$currencyFormat = \CCurrencyLang::GetCurrencyFormat($arResult['RUB']);
$currencyString = preg_replace('/(^|[^&])#\s?/', '${1}', $currencyFormat['FORMAT_STRING']);
$cartName = 'zakaz';


$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();

$type = $request->getQuery('export') ?: '';


$filename = $cartName . '.' . $type;
if (mb_strtolower(SITE_CHARSET) !== 'utf-8') {
    /** @var string */
    $filename = Bitrix\Main\Text\Encoding::convertEncoding($filename, SITE_CHARSET, 'utf-8');
}


/** @var \Redsign\B2BPortal\Spreadsheet\PhpSpreadsheetWriter */
$container = DI\ServiceContainer::getInstance();

$writer = $container->get('Spreadsheet\Writer');


$writer->addRow(
    [
        "Наименование",
        'Артикул',
        'Цена (руб)',
        'Количество',
        'Сумма (руб)',
    ],
    [
        'autoSize' => true,
        'style' => [
            'font' => [
                'bold' => true
            ]
        ]
    ]
);

$ORDER_ID = $request->getQuery('order') ?: '';
if ($arOrder = CSaleOrder::GetByID($ORDER_ID)){
    $PRICE = $arOrder['PRICE'];
}


if ($ORDER_ID) {
    CModule::IncludeModule('sale');
    $res = CSaleBasket::GetList(array(), array("ORDER_ID" => $ORDER_ID));

    while ($arItem = $res->Fetch()) {

        $db_props = CIBlockElement::GetProperty(5, $arItem['PRODUCT_ID'], array("sort" => "asc"), array("CODE" => "CML2_ARTICLE"));

        if ($ar_props = $db_props->Fetch()) {
            AddMessage2Log($ar_props, "order");
        }


        $arResult['ROWS'][] = [
            'NAME'=>$arItem['NAME'],
            'ARTICLE'=>$ar_props['VALUE'],
            'PRICE'=>intval($arItem['PRICE']),
            'QUANTITY'=>intval($arItem['QUANTITY']),
            'SUM_PRICE'=>intval($PRICE),
            'URL'=>$arItem['DETAIL_PAGE_URL']
        ];

    }

}

AddMessage2Log($host);
AddMessage2Log($arResult);

foreach ($arResult['ROWS'] as $rowData)
{
    $writer->addRow([
        [$rowData['NAME'], ['url' => $host . $rowData['URL']]],
        $rowData['ARTICLE'],
        $rowData['PRICE'],
        $rowData['QUANTITY'],
        $rowData['SUM_PRICE'],
    ]);
}


$writer->openToBrowser($filename);

die();

