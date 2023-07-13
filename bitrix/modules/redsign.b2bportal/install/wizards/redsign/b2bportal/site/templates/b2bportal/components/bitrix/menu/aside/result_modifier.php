<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (empty($arResult))
    return;

$lastlvl1key = 0;
foreach ($arResult as $key1 => $arItem)
{
    if ($arItem['DEPTH_LEVEL'] == 1)
    {
        $lastlvl1key = $key1;
    }

    if ($arItem['SELECTED'] && $arItem['DEPTH_LEVEL'] > 1)
    {
        $arResult[$lastlvl1key]['SELECTED'] = 1;
    }
}
