<?php

use Bitrix\Main\Localization\Loc;

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

if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDERS"), $arResult['PATH_TO_ORDERS']);
$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_ORDER_DETAIL", array("#ID#" => urldecode($arResult["VARIABLES"]["ID"]))));

$arDetParams = array(
	"PATH_TO_LIST" => $arResult["PATH_TO_ORDERS"],
	"PATH_TO_CANCEL" => $arResult["PATH_TO_ORDER_CANCEL"],
	"PATH_TO_COPY" => $arResult["PATH_TO_ORDER_COPY"],
	"PATH_TO_PAYMENT" => $arParams["PATH_TO_PAYMENT"],
	"SET_TITLE" => $arParams["SET_TITLE"],
	"ID" => $arResult["VARIABLES"]["ID"],
	"ACTIVE_DATE_FORMAT" => $arParams["ACTIVE_DATE_FORMAT"],
	"ALLOW_INNER" => $arParams["ALLOW_INNER"],
	"ONLY_INNER_FULL" => $arParams["ONLY_INNER_FULL"],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	"RESTRICT_CHANGE_PAYSYSTEM" => $arParams["ORDER_RESTRICT_CHANGE_PAYSYSTEM"],
	"DISALLOW_CANCEL" => $arParams["ORDER_DISALLOW_CANCEL"],
	"REFRESH_PRICES" => $arParams["ORDER_REFRESH_PRICES"],
	"HIDE_USER_INFO" => $arParams["ORDER_HIDE_USER_INFO"],
	"DOCUMENTS_IBLOCK_ID" => $arParams["DOCUMENTS_IBLOCK_ID"],
	"CUSTOM_SELECT_PROPS" => $arParams["CUSTOM_SELECT_PROPS"],
	"USE_CLAIMS" => $arParams["USE_CLAIMS"],
	"CLAIMS_PATH" => $arParams["CLAIMS_PATH"],
	"ADD_CLAIM_PATH" => $arParams["ADD_CLAIM_PATH"],
	"CLAIM_DETAIL" => $arParams["CLAIM_DETAIL"]
);

foreach ($arParams as $key => $val)
{
	if(strpos($key, "PROP_") !== false)
		$arDetParams[$key] = $val;
}

$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.detail",
	"portlets",
	$arDetParams,
	$component
);
