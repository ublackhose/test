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


if ($arParams['SHOW_PROFILE_PAGE'] !== 'Y')
{
	LocalRedirect($arParams['SEF_FOLDER']);
}

if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$APPLICATION->AddChainItem(Loc::getMessage("SPS_CHAIN_PROFILE"));
$APPLICATION->SetTitle(Loc::getMessage("SPS_TITLE_PROFILE"));

$componentProfileListParams = [
	"PATH_TO_DETAIL" => $arResult['PATH_TO_PROFILE_DETAIL'],
	"PATH_TO_DELETE" => $arResult['PATH_TO_PROFILE_DELETE'],
	"PER_PAGE" => $arParams["PROFILES_PER_PAGE"],
	"SET_TITLE" => 'N',
	"URL_TO_ADD" => $arParams["URL_TO_ADD"],
];

$componentSorterParams = [
	'SORT_FIELDS' => $arParams['SORT_FIELDS'],
	'SORT_DEFAULT_FIELD' => $arParams['SORT_DEFAULT_FIELD'],
	'SORT_DEFAULT_ORDER' => $arParams['SORT_DEFAULT_ORDER'],
	'PERPAGE_FIELDS' => $arParams['PERPAGE_FIELDS'],
	'PERPAGE_DEFAULT' => $arParams['PERPAGE_DEFAULT'],
];

$componentSorterParams['SORT_FIELDS'] = [
	'NAME',
	'DATE_UPDATE',
	'SALE_TYPE',
	'PROPS_B2B_INN',
	'PROPS_B2B_PHONE',
];
$componentSorterParams['SORT_FIELDS'] = array_merge($componentSorterParams['SORT_FIELDS'], $arParams['COMPANIES_HEADERS_SORT']);

$componentSorterParams['PROPS_CODE'] = $arParams['COMPANIES_HEADERS'];

$componentProfileListParams = array_merge($componentProfileListParams, $componentSorterParams);

$APPLICATION->IncludeComponent(
	'redsign:b2bportal.sale.personal.profile.list',
	'',
	$componentProfileListParams,
	$component
);
