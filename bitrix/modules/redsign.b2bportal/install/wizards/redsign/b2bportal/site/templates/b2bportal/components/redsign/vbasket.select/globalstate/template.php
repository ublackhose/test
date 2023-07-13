<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var Redsign\Components\VBasketSelect $component
 * @var array $arParams
 * @var array $arResult
 * @var array $globalState
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


global $globalState;

$globalState['baskets'] = $arResult;
$globalState['cartList'] = $arResult;
