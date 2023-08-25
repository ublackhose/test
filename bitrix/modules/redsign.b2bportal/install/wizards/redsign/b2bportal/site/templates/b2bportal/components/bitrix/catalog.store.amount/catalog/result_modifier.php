<?php

use Bitrix\Main\Loader;
use Bitrix\Catalog\StoreTable;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (empty($arResult['STORES']) || !Loader::includeModule('catalog'))
    return;

$arStores = [];
$arIds = [];
foreach ($arResult['STORES'] as $pid => $arProperty)
{
    $arIds[] = $arProperty['ID'];
}

$arFilter = ['=ID' => $arIds];
$arSelect = ['ID', 'TITLE', 'ADDRESS'];

$query = StoreTable::query();
$query->setFilter($arFilter);
$query->setSelect($arSelect);
$res = $query->exec();

while ($row = $res->fetch())
{
    $arStores[$row['ID']] = $row;
}

if (empty($arStores))
    return;

foreach ($arResult['STORES'] as $pid => $arProperty)
{
    if (empty($arStores[$arProperty['ID']]))
    {
        continue;
    }

    $iStoreId = $arProperty['ID'];
    $arTemp = $arStores[$iStoreId];
    $arResult['STORES'][$pid]['NAME'] = $arTemp['TITLE'];
    $arR