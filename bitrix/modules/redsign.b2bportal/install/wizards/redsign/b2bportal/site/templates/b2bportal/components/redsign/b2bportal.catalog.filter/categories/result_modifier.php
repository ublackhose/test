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


if (Loader::includeModule('iblock'))
{
    $obCache = new CPHPCache();
    $cacheUniqStr = serialize([
        'SECTION_ID' => $arParams['SECTION_ID'],
        'SECTION_CODE' => $arParams['SECTION_CODE']
    ]);
    $cacheInitDir = '/iblock/';

    if ($obCache->InitCache(36000, $cacheUniqStr, $cacheInitDir))
    {
        $vars = $obCache->GetVars();
        $arResult['SECTION'] = $vars['SECTION'];
        $arResult['SECTIONS'] = $vars['SECTIONS'];
    }
    elseif ($obCache->StartDataCache())
    {
        $arSelect = ['ID', 'NAME', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'DEPTH_LEVEL', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'];
        $arFilter = [
            "ACTIVE" => "Y",
            "GLOBAL_ACTIVE" => "Y",
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "CNT_ACTIVE" => "Y",
        ];
        if($arParams['SECTION_ID'] > 0)
        {
            $arFilter['ID'] = $arParams['SECTION_ID'];
            $rsSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
            $arResult['SECTION'] = $rsSections->GetNext();
        }
        elseif('' != $arParams['SECTION_CODE'])
        {
            $arFilter['=CODE'] = $arParams['SECTION_CODE'];
            $rsSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);
            $arResult['SECTION'] = $rsSections->GetNext();
        }
        unset($arFilter, $arSelect);

        if (isset($arResult['SECTION']) && is_array($arResult['SECTION']))
        {
            $arSort = ['left_margin' => 'asc', 'SORT' => 'ASC'];
            $arSelect = ['ID', 'NAME', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'DEPTH_LEVEL', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'];
            $arFilter = [
                "ACTIVE" => "Y",
                "GLOBAL_ACTIVE" => "Y",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "CNT_ACTIVE" => "Y",
                'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] + 1,
                'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN']
            ];

            $rsSections = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect);
            while($arSection = $rsSections->GetNext())
                $arResult["SECTIONS"][] = $arSection;

            unset($arFilter, $arSelect);
        }

        $obCache->EndDataCache([
            'SECTION' => $arResult['SECTION'],
            'SECTIONS' => $arResult['SECTIONS']
        ]);
    }
}
