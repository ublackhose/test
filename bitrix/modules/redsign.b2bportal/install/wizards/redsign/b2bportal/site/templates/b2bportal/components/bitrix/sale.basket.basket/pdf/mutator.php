<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Sale;
use Bitrix\Sale\PriceMaths;
use Redsign\B2BPortal\Iblock\PropertyFeature;
use Redsign\B2BPortal\Helpers\ArrHelper;

/**
 *
 * This file modifies result for every request (including AJAX).
 * Use it to edit output result for "{{ mustache }}" templates.
 *
 * @var CMain $APPLICATION
 * @var \CBitrixBasketComponent $this
 * @var array $result
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();
$result['HOST'] = $host;

$articleCodes = [];
$usePropertyFeatures = PropertyFeature::isEnabledFeatures();
$productIds = array_unique(ArrHelper::pluck($this->basketItems, 'PRODUCT_ID'));
$iblockIds = \CIBlockElement::GetIBlockByIDList($productIds);

$result['COLUMNS'] = [];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_NAME_LABEL'),
    'field' => 'name',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_PRICE_LABEL'),
    'field' => 'price',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_QUANTITY_LABEL'),
    'field' => 'quantity',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_SUM_PRICE_LABEL'),
    'field' => 'sum_price',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];

foreach ($this->basketItems as $row)
{
    $rowData = [
        'ID' => $row['ID'],
        'SORT' => $row['SORT'],
        'MODULE' => $row['MODULE'],
        'PRODUCT_PROVIDER_CLASS' => $row['PRODUCT_PROVIDER_CLASS'],
        'PRODUCT_ID' => $row['PRODUCT_ID'],
        'PROPS_ALL' => $row['PROPS_ALL'],
        'NAME' => $row['NAME'],
        'QUANTITY' => $row['QUANTITY'],
        'PRICE' => $row['PRICE'],
        'PRICE_FORMATTED' => $row['PRICE_FORMATED'],
        'SUM_PRICE' => $row['SUM_VALUE'],
        'SUM_PRICE_FORMATTED' => $row['SUM'],
        'MEASURE_RATIO' => isset($row['MEASURE_RATIO']) ? $row['MEASURE_RATIO'] : 1,
        'MEASURE_TEXT' => $row['MEASURE_TEXT'],
        'AVAILABLE_QUANTITY' => $row['AVAILABLE_QUANTITY'],
        'CHECK_MAX_QUANTITY' => $row['CHECK_MAX_QUANTITY'] === 'Y',
        'NOT_AVAILABLE' => $row['NOT_AVAILABLE'] === true,
        'ARTICLE' => '',
        'URL' => $host . $row['DETAIL_PAGE_URL'],
    ];

    if ($usePropertyFeatures)
    {
        if (isset($iblockIds[$row['PRODUCT_ID']]))
        {
            $iblockId = $iblockIds[$row['PRODUCT_ID']];
            if (!isset($articleCodes[$iblockId]))
            {
                $articleCodes[$iblockId] = PropertyFeature::getFirstArticlePropertyCode(
                    (int) $iblockId,
                    ['CODE' => 'Y']
                );
            }

            if (isset($row['PROPERTY_' . $articleCodes[$iblockId] . '_VALUE']))
            {
                $rowData['ARTICLE'] = $row['PROPERTY_' . $articleCodes[$iblockId] . '_VALUE'];
            }
        }
    }
    elseif (isset($row['PROPERTY_' . $this->arParams['ARTICLE_PROPERTY'] . '_VALUE']))
    {
        $rowData['ARTICLE'] = $row['PROPERTY_' . $this->arParams['ARTICLE_PROPERTY'] . '_VALUE'];
    }

    $result['ROWS'][] = $rowData;
}


$basket = $this->getBasketStorage()->getOrderableBasket();
$this->initializeBasketOrderIfNotExists($basket);

$basketPrice = $basket->getPrice();
$basketWeight = $basket->getWeight();
$basketBasePrice = $basket->getBasePrice();
$basketVatSum = $basket->getVatSum();

$siteCurrency = Sale\Internals\SiteCurrencyTable::getSiteCurrency($this->getSiteId());

$allSum = PriceMaths::roundPrecision($basketPrice);

$arSummary = [
    'count' => count($this->basketItems),
    'allSum' => $allSum,
    'allSum_FORMATED' => CCurrencyLang::CurrencyFormat($allSum, $siteCurrency, true),
    'allWeight' => $basketWeight,
    'allWeight_FORMATED' => roundEx($basketWeight / $this->weightKoef, SALE_WEIGHT_PRECISION) . ' ' . $this->weightUnit,
];

if ($this->priceVatShowValue === 'Y')
{
    $arSummary['allVATSum'] = PriceMaths::roundPrecision($basketVatSum);
    $arSummary['allVATSum_FORMATED'] = CCurrencyLang::CurrencyFormat($arSummary['allVATSum'], $siteCurrency, true);
    $arSummary['allSum_wVAT_FORMATED'] = CCurrencyLang::CurrencyFormat($allSum - $result['allVATSum'], $siteCurrency, true);
}

$result['SUMMARY'] = $arSummary;
