<?php

use Bitrix\Main\Loader;
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
 * @var CBitrixBasketComponent $this
 * @var array $result
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!Loader::includeModule('redsign.b2bportal'))
    return;

$enablePreviewPicture = isset($this->arParams['ENABLE_PREVIEW_PICTURE']) && $this->arParams['ENABLE_PREVIEW_PICTURE'] === 'Y';

$result['COLUMNS'] = [];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_NAME_LABEL'),
    'field' => 'NAME',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_PRICE_LABEL'),
    'field' => 'PRICE',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_QUANTITY_LABEL'),
    'field' => 'QUANTITY',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_SUM_PRICE_LABEL'),
    'field' => 'SUM_PRICE',
    'type' => 'number',
    'sortable' => true,
    'html' => false,
];
$result['COLUMNS'][] = [
    'label' => Loc::getMessage('RS_B2BPORTAL_SBB_HEADER_ACTIONS_LABEL'),
    'field' => 'ACTIONS',
    'sortable' => false,
    'html' => false,
];

$usePropertyFeatures = PropertyFeature::isEnabledFeatures();

$articleCodes = [];
$brandCodes = [];

$productIds = array_unique(ArrHelper::pluck($this->basketItems, 'PRODUCT_ID'));
$iblockIds = \CIBlockElement::GetIBlockByIDList($productIds);

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
        'URL' => $row['DETAIL_PAGE_URL'],
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

    if ($enablePreviewPicture)
    {
        $picture = false;
        if (!empty($row['PREVIEW_PICTURE_SRC_ORIGINAL']))
        {
            $picture = $row['PREVIEW_PICTURE_SRC_ORIGINAL'];
        }
        elseif (!empty($row['DETAIL_PICTURE_SRC_ORIGINAL']))
        {
            $picture = $row['DETAIL_PICTURE_SRC_ORIGINAL'];
        }

        $rowData['PICTURE'] = $picture;
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

$result['PDF_PATH'] = isset($arParams['PDF_PATH']) ? $arParams['PDF_PATH'] : SITE_DIR . 'personal/cart/pdf.php';

if (!isset($this->arParams['EXPORT_TYPES']))
{
    $this->arParams['EXPORT_TYPES'] = ['ods', 'xlsx', 'csv'];
}
$result['EXPORT_TYPES'] = array_filter($this->arParams['EXPORT_TYPES'], function ($type) {
    return in_array($type, ['ods', 'xlsx', 'csv']);
});
