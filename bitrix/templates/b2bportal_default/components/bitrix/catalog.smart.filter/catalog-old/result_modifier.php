<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arParams["FILTER_VIEW_MODE"] = (isset($arParams["FILTER_VIEW_MODE"]) && toUpper($arParams["FILTER_VIEW_MODE"]) == "HORIZONTAL") ? "HORIZONTAL" : "VERTICAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";

if (isset($arResult["JS_FILTER_PARAMS"])) {
    $arResult['JS_FILTER_PARAMS'] = [];
}

$arResult['JS_FILTER_PARAMS']['FILTER_NAME'] = $arParams['FILTER_NAME'];

$skipHiddenProps = ['hide_not_avalaible'];
if (isset($arParams['SKIP_HIDDEN_PROPS']) && is_array($arParams['SKIP_HIDDEN_PROPS'])) {
    $skipHiddenProps = array_merge(
        $skipHiddenProps,
        $arParams['SKIP_HIDDEN_PROPS']
    );
}

$arParams['SKIP_HIDDEN_PROPS'] = $skipHiddenProps;
unset($skipHiddenProps);
