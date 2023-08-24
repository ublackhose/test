<?php

use Bitrix\Main\Engine\Response\Converter;
use Bitrix\Main\Engine\Response\AjaxJson;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$converter = Converter::toJson();

$jsResult = [];

foreach ($arResult['CATEGORIES'] as $categoryId => $category)
{
    $items = [];

    foreach ($category['ITEMS'] as $searchItem)
    {
        if ($searchItem['TYPE'] == 'all') continue;

        if (isset($arResult["ELEMENTS"][$searchItem['ITEM_ID']]))
        {
            $catalogItem = $arResult['ELEMENTS'][$searchItem['ITEM_ID']];

            $iblockId = $catalogItem['IBLOCK_ID'];

            $vendorCode = '';
            $vendorCodeProperty = $arResult['ARTICLE_PROP_CODES'][$iblockId];
            if (isset($catalogItem['PROPERTY_' . $vendorCodeProperty . '_VALUE']))
            {
                $vendorCode = $catalogItem['PROPERTY_' . $vendorCodeProperty . '_VALUE'];
            }

            $items[] = [
                'id' => (int) $catalogItem['ID'],
                'name' => $catalogItem['NAME'],
                'type' => $catalogItem['TYPE'],
                'url' => $searchItem['URL'],
                'vendorCode' => $vendorCode,
                'picture' => (is_array($catalogItem['PICTURE'])) ? $catalogItem['PICTURE']['src'] : $templateFolder . '/images/no_photo.png',
                'price' => $converter->process($catalogItem['MIN_PRICE']),
                'canBuy' => $catalogItem['CAN_BUY_ZERO'] === 'Y' ? true : $catalogItem['AVAILABLE'] === 'Y'
            ];
        }
    }
    unset($item);

    $jsResult[] = [
        'id' => $categoryId,
        'id1' => 123,
        'title' => $category['TITLE'],
        'items' => $items
    ];
}

$jsonResponse = AjaxJson::createSuccess($jsResult);


$jsonResponse->send();
