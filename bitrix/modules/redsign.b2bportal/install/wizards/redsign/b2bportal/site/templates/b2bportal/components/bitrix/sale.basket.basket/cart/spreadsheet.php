<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\DI;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixBasketComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

$currencyFormat = \CCurrencyLang::GetCurrencyFormat($arResult['CURRENCY']);
$currencyString = preg_replace('/(^|[^&])#\s?/', '${1}', $currencyFormat['FORMAT_STRING']);

/** @var string */
$cartName = Loc::getMessage('RS_B2B_SBB_SPREADSHEET_CART_NAME') ?: '';

if (Loader::includeModule('redsign.vbasket'))
{
    /** @var \Redsign\VBasket\Repository\BasketRepository $basketRepository */
    $basketRepository = \Redsign\VBasket\Core::container()->get('basket_repository');

    /** @var \Redsign\VBasket\Context */
    $context = \Redsign\VBasket\Core::container()->get('context');

    /** @var \Redsign\VBasket\Basket|null $basket */
    $basket = $basketRepository->getByCodeWithContext(
        \Redsign\VBasket\BasketHelper::getCurrentBasketCode(),
        $context
    );

    if ($basket)
    {
        $cartName .= ' - ' . $basket->getName();
    }
}


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();

/** @var string */
$type = $request->getQuery('export') ?: '';

$rows = [];
foreach ($arResult['ROWS'] as $rowData)
{
    $rows[] = [
        $rowData['NAME'],
        $rowData['ARTICLE'],
        $rowData['PRICE'],
        $rowData['QUANTITY'],
        $rowData['SUM_PRICE'],
    ];
}

$container = DI\ServiceContainer::getInstance();

$filename = $cartName . '.' . $type;
if (mb_strtolower(SITE_CHARSET) !== 'utf-8')
{
    /** @var string */
    $filename = Bitrix\Main\Text\Encoding::convertEncoding($filename, SITE_CHARSET, 'utf-8');
}

/** @var \Redsign\B2BPortal\Spreadsheet\PhpSpreadsheetWriter */
$writer = $container->get('Spreadsheet\Writer');
$writer->addRow(
    [
        Loc::getMessage('RS_B2B_SBB_SPREADSHEET_COLUMN_NAME'),
        Loc::getMessage('RS_B2B_SBB_SPREADSHEET_COLUMN_ARTICLE'),
        Loc::getMessage('RS_B2B_SBB_SPREADSHEET_COLUMN_PRICE', ['#CURRENCY_STRING#' => $currencyString]),
        Loc::getMessage('RS_B2B_SBB_SPREADSHEET_COLUMN_QUANTITY'),
        Loc::getMessage('RS_B2B_SBB_SPREADSHEET_COLUMN_SUM', ['#CURRENCY_STRING#' => $currencyString]),
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
