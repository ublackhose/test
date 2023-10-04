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
$cartName = 'doc';


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
        "Договор",
        'Дата реализации',
        'Номер УПД',
        'Сумма долга',
        'Сумма реализации',
        'Дата оплаты',
        'Дней просрочки',
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

$ORDERS = json_decode(str_replace(';','',$request->getQuery('orders')) ?: '');



foreach ($ORDERS as $order) {

    $orderad = \Bitrix\Sale\Order::load($order);


    $ord = $orderad->getFields()->getValues();


    $propertyCollection = $orderad->getPropertyCollection();
    $property = $propertyCollection->getItemByOrderPropertyCode("NUMBER_UPD");
    $num_cur = $property->getValue();
    $property = $propertyCollection->getItemByOrderPropertyCode("TREATY");
    $treaty = $property->getValue();
    $property = $propertyCollection->getItemByOrderPropertyCode("DAYS_OVERDUE");
    $days_overdue = $property->getValue();


    $writer->addRow([
        $treaty,
        $ord['DATE_INSERT'],
        $num_cur,
        $ord['SUM_PAID'],
        ($ord['PRICE'] - $ord['SUM_PAID']),
        $ord['PAYED'] == 'N' ? "Не оплачен" : date ( 'd.m.Y' ,strtotime($ord['DATE_PAYED'])),
        $days_overdue,
    ]);

}

$writer->openToBrowser($filename);

die();


die();

