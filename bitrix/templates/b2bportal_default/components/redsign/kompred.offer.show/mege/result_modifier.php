<?php

use Bitrix\Main\Loader;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


/** @var RedsignKompredOfferShow */
$component = $this->getComponent();
$component->fillMeasures($arResult);
$component->formatPrices($arResult);

if (isset($arResult['OFFER']))
{
    $elementsData = [];

    if (Loader::includeModule('iblock'))
    {
        $elementIds = array_column($arResult['OFFER']['PRODUCTS'], 'PRODUCT_ID');
        if ($elementIds)
        {
            $filter = ['=ID' => $elementIds];
            $select = [
                'ID', 'CODE', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE',
                'DETAIL_PAGE_URL', 'PROPERTY_' . $arParams['PROP_VENDOR_CODE']
            ];

            $elementIterator = \CIBlockElement::GetList([], $filter, false, false, $select);

            while($elementData = $elementIterator->GetNext())
            {
                $elementsData[$elementData['ID']] = $elementData;
            }

            unset($elementIterator, $elementData, $filter, $select, $propCode);
        }
    }

    foreach ($arResult['OFFER']['PRODUCTS'] as $i => ['PRODUCT_ID' => $elementId])
    {
        if (!isset($elementsData[$elementId]))
            continue;

        $elementData = $elementsData[$elementId];

        $vendorCode = '';
        if (isset($elementData['PROPERTY_' . $arParams['PROP_VENDOR_CODE'] . '_VALUE']))
        {
            $vendorCode = $elementData['PROPERTY_' . $arParams['PROP_VENDOR_CODE'] . '_VALUE'];
        }

        $arResult['OFFER']['PRODUCTS'][$i]['VENDOR_CODE'] = $vendorCode;
        $arResult['OFFER']['PRODUCTS'][$i]['INDEX'] = $i + 1;
    }
}
