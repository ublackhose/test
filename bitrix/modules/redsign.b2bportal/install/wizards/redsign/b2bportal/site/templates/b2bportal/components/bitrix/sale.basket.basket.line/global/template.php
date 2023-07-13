<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var SaleBasketLineComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$state = [
	'totalPrice' => $arResult['TOTAL_PRICE'],
	'totalPriceRaw' => $arResult['TOTAL_PRICE_RAW'],
	'numProducts' => $arResult['NUM_PRODUCTS'],
	'addedIds' => [],
	'quantityByIds' => [],
	'products' => []
];

foreach ($arResult['CATEGORIES'] as $category => $items)
{
	if (empty($items))
		continue;

	foreach ($items as $v)
	{
		if (!in_array($v['PRODUCT_ID'], $state['addedIds']))
		{
			$state['addedIds'][] = (int) $v['PRODUCT_ID'];
		}

		if ($category === 'READY')
		{
			$state['quantityByIds'][$v['PRODUCT_ID']] = (float) $v['QUANTITY'];
		}
	}
}

global $globalState;
$globalState['cart'] = $state;
