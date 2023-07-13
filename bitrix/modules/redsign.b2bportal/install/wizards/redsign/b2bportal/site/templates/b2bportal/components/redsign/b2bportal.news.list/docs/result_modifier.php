<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\UserTable;
use Bitrix\Sale\Internals\OrderTable;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arParams['PROP_OWNER_ID'] = $arParams['PROP_OWNER_ID'] ?: 'OWNER_ID';
$arParams['PROP_ORDER_ID'] = $arParams['PROP_ORDER_ID'] ?: 'ORDER_ID';
$arParams['PROP_TYPE'] = $arParams['PROP_TYPE'] ?: 'TYPE';
$arParams['PROP_FILE'] = $arParams['PROP_FILE'] ?: 'FILE';
$arParams['PROP_GEN_TYPE'] = $arParams['PROP_GEN_TYPE'] ?: 'GEN_TYPE';

$arParams['GEN_DOC_PATH'] = !empty($arParams['GEN_DOC_PATH']) ? $arParams['GEN_DOC_PATH'] : Option::get('redsign.b2bportal', 'generate_docs_path', '', SITE_ID);

if (empty($arResult['ITEMS']))
    return;

$arOwnerIds = [];
$arOrderIds = [];
foreach ($arResult['ITEMS'] as $key => $item)
{
    if (empty($item['PROPERTIES'][$arParams['PROP_OWNER_ID']]['VALUE']))
        continue;

    $arOwnerIds[$key] = $item['PROPERTIES'][$arParams['PROP_OWNER_ID']]['VALUE'];
    $arOrderIds[$key] = $item['PROPERTIES'][$arParams['PROP_ORDER_ID']]['VALUE'];
}

$arOwnerItems = [];
if (!empty($arOwnerIds))
{
    $arSelect = [
        'ID',
        'LOGIN',
        'NAME',
        'LAST_NAME',
    ];
    $arOrder = [];
    $arFilter = [
        'ID' => $arOwnerIds,
    ];

    $query = UserTable::query();
    $query->setSelect($arSelect);
    $query->setOrder($arOrder);
    $query->setFilter($arFilter);

    $res = $query->exec();

    while ($row = $res->fetch())
    {
        $arOwnerItems[$row['ID']] = $row;
    }
}

$arOrderItems = [];
if (!empty($arOrderIds))
{
    $arSelect = [
        'ID',
        'ACCOUNT_NUMBER',
    ];
    $arOrder = [];
    $arFilter = [
        'ID' => $arOrderIds,
    ];

    $query = OrderTable::query();
    $query->setSelect($arSelect);
    $query->setOrder($arOrder);
    $query->setFilter($arFilter);

    $res = $query->exec();

    while ($row = $res->fetch())
    {
        $arOrderItems[$row['ID']] = $row;
    }
}

foreach ($arResult['ITEMS'] as $key => $item)
{
    $ownerId = $arOwnerIds[$key];
    $arUser = $arOwnerItems[$ownerId];
    $fullName = $arUser['LOGIN'];
    if (!empty($arUser['NAME']))
    {
        $fullName = $arUser['NAME'];
        if (!empty($arUser['LAST_NAME']))
        {
            $fullName .= ' ' . $arUser['LAST_NAME'];
        }
    }

    $arResult['ITEMS'][$key]['PROPERTIES'][$arParams['PROP_OWNER_ID']]['RS_B2B_DISPLAY_VALUE'] = $fullName;


    $orderId = $arOrderIds[$key];
    if (!empty($orderId) && !empty($arOrderItems[$orderId]))
    {
        $arResult['ITEMS'][$key]['PROPERTIES'][$arParams['PROP_ORDER_ID']]['RS_B2B_DISPLAY_VALUE'] = $arOrderItems[$orderId]['ACCOUNT_NUMBER'];
    }

    if (
        isset($arResult['ITEMS'][$key]['PROPERTIES'][$arParams['PROP_GEN_TYPE']]) &&
        !empty($arResult['ITEMS'][$key]['PROPERTIES'][$arParams['PROP_GEN_TYPE']]['VALUE'])
    )
    {
        $arResult['ITEMS'][$key]['FILE_PATH'] = CComponentEngine::MakePathFromTemplate($arParams['GEN_DOC_PATH'], [
            'SITE_DIR' => SITE_DIR,
            'DOCUMENT_ID' => $arResult['ITEMS'][$key]['ID']
        ]);
    }
    else
    {
        $arResult['ITEMS'][$key]['FILE_PATH'] = \CFile::GetPath($item['PROPERTIES'][$arParams['PROP_FILE']]['VALUE']);
    }
}

$arProps = reset($arResult['ITEMS'])['PROPERTIES'];
if (!empty($arProps))
{
    $arParams['PROPERTY_CODE_ID'] = [];

    foreach ($arProps as $arProp)
    {
        $arParams['PROPERTY_CODE_ID'][$arProp['CODE']] = $arProp['ID'];
    }
}
