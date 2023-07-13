<?php

use Redsign\B2BPortal\Iblock\PropertyFeature;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$elementIds = [];
foreach ($arResult['CATEGORIES'] as $category => $cartItems)
{
    foreach ($cartItems as $cartItem)
    {
        if ($cartItem['PRODUCT_ID'])
            $elementIds[] = $cartItem['PRODUCT_ID'];
    }
}

$arResult['ARTICLE_PROP_CODES'] = [];
$arResult['ELEMENTS'] = [];
if ($elementIds)
{
    $iblocksIterator = \Bitrix\Iblock\ElementTable::getList([
        'select' => ['IBLOCK_ID'],
        'filter' => ['=ID' => $elementIds],
        'group' => ['IBLOCK_ID']
    ]);

    $iblocks = [];
    while ($iblock = $iblocksIterator->fetch())
    {
        ['IBLOCK_ID' => $iblockId] = $iblock;

        if ($iblockId)
            $iblocks[] = $iblockId;
    }
    if (PropertyFeature::isEnabledFeatures())
    {
        foreach ($iblocks as $iblockId)
        {
            $arResult['ARTICLE_PROP_CODES'][$iblockId] = PropertyFeature::getFirstArticlePropertyCode(
                (int) $iblockId,
                ["CODE" => "Y"]
            );
        }
    }
    else
    {
        foreach ($iblocks as $iblockId)
        {
            $arResult['ARTICLE_PROP_CODES'][$iblockId] = $arParams['PROP_CODE_ARTICLE'];
        }
    }

    $select = [
        'ID',
        'IBLOCK_ID',
        'DETAIL_PAGE_URL'
    ];
    foreach ($arResult['ARTICLE_PROP_CODES'] as $code)
    {
        $select[] = 'PROPERTY_' . $code;
    }

    $filter = ['=ID' => $elementIds];

    $elementsIterator = \CIBlockElement::GetList(
        [],
        $filter,
        false,
        false,
        $select
    );

    while ($element = $elementsIterator->GetNext())
    {
        $arResult['ELEMENTS'][$element['ID']] = $element;
    }
}
