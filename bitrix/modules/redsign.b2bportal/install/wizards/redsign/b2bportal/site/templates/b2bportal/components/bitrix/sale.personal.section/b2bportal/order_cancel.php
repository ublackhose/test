<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var PersonalOrderSection $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if ($arParams['SHOW_ORDER_PAGE'] !== 'Y')
{
	LocalRedirect($arParams['SEF_FOLDER']);
}
elseif ($arParams['ORDER_DISALLOW_CANCEL'] === 'Y')
{
	LocalRedirect($arResult['PATH_TO_ORDERS']);
}

if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDERS"), $arResult['PATH_TO_ORDERS']);
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDER_DETAIL", array("#ID#" => $arResult["VARIABLES"]["ID"])));

$portlet = new Portlet();

$portlet->body(function () use ($arParams, $arResult, $APPLICATION, $component) {

	$APPLICATION->IncludeComponent(
		"bitrix:sale.personal.order.cancel",
		"bootstrap_v4",
		array(
			"PATH_TO_LIST" => $arResult["PATH_TO_ORDERS"],
			"PATH_TO_DETAIL" => $arResult["PATH_TO_ORDER_DETAIL"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"ID" => $arResult["VARIABLES"]["ID"],
		),
		$component
	);
});

$portlet->render();
