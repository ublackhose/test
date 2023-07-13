<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

$componentNewsListParams = [
	'IBLOCK_TYPE'	=>	$arParams['IBLOCK_TYPE'],
	'IBLOCK_ID' => $arParams['IBLOCK_ID'],
	'NEWS_COUNT'	=>	$arParams['NEWS_COUNT'],
	'SORT_BY1' => $arParams['SORT_BY1'],
	'SORT_ORDER1'	=>	$arParams['SORT_ORDER1'],
	'SORT_BY2' => $arParams['SORT_BY2'],
	'SORT_ORDER2'	=>	$arParams['SORT_ORDER2'],
	'FIELD_CODE'	=>	$arParams['LIST_FIELD_CODE'],
	'PROPERTY_CODE'	=>	$arParams['LIST_PROPERTY_CODE'],
	'DETAIL_URL'	=>	$arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'],
	'SECTION_URL'	=>	$arResult['FOLDER'] . $arResult['URL_TEMPLATES']['section'],
	'IBLOCK_URL'	=>	$arResult['FOLDER'] . $arResult['URL_TEMPLATES']['news'],
	'DISPLAY_PANEL'	=>	$arParams['DISPLAY_PANEL'],
	'SET_TITLE' => $arParams['SET_TITLE'],
	'SET_STATUS_404' => $arParams['SET_STATUS_404'],
	'INCLUDE_IBLOCK_INTO_CHAIN'	=>	$arParams['INCLUDE_IBLOCK_INTO_CHAIN'],
	'CACHE_TYPE'	=>	$arParams['CACHE_TYPE'],
	'CACHE_TIME'	=>	$arParams['CACHE_TIME'],
	'CACHE_FILTER'	=>	$arParams['CACHE_FILTER'],
	'CACHE_GROUPS'	=> $arParams['CACHE_GROUPS'],
	'DISPLAY_TOP_PAGER'	=>	$arParams['DISPLAY_TOP_PAGER'],
	'DISPLAY_BOTTOM_PAGER'	=>	$arParams['DISPLAY_BOTTOM_PAGER'],
	'PAGER_TITLE' => $arParams['PAGER_TITLE'],
	'PAGER_TEMPLATE'	=>	$arParams['PAGER_TEMPLATE'],
	'PAGER_SHOW_ALWAYS'	=>	$arParams['PAGER_SHOW_ALWAYS'],
	'PAGER_DESC_NUMBERING'	=>	$arParams['PAGER_DESC_NUMBERING'],
	'PAGER_DESC_NUMBERING_CACHE_TIME'	=>	$arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
	'PAGER_SHOW_ALL'	=> $arParams['PAGER_SHOW_ALL'],
	'DISPLAY_DATE' => $arParams['DISPLAY_DATE'],
	'DISPLAY_NAME' => 'Y',
	'DISPLAY_PICTURE'	=>	$arParams['DISPLAY_PICTURE'],
	'DISPLAY_PREVIEW_TEXT'	=>	$arParams['DISPLAY_PREVIEW_TEXT'],
	'PREVIEW_TRUNCATE_LEN'	=>	$arParams['PREVIEW_TRUNCATE_LEN'],
	'ACTIVE_DATE_FORMAT'	=>	$arParams['LIST_ACTIVE_DATE_FORMAT'],
	'USE_PERMISSIONS'	=>	$arParams['USE_PERMISSIONS'],
	'GROUP_PERMISSIONS'	=>	$arParams['GROUP_PERMISSIONS'],
	'FILTER_NAME' => $arParams['FILTER_NAME'],
	'HIDE_LINK_WHEN_NO_DETAIL'	=>	$arParams['HIDE_LINK_WHEN_NO_DETAIL'],
	'CHECK_DATES' => $arParams['CHECK_DATES'],
	//
	'TEMPLATE_URL_OWNER_ID' =>	$arParams['TEMPLATE_URL_OWNER_ID'],
	'TEMPLATE_URL_ORDER_ID' =>	$arParams['TEMPLATE_URL_ORDER_ID'],
];

$componentFilterParams = [
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	"FILTER_NAME" => $arParams["FILTER_NAME"],
	"CACHE_TYPE" => $arParams["CACHE_TYPE"],
	"CACHE_TIME" => $arParams["CACHE_TIME"],
	"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
	"FIELD_CODE" => [
		'ACTIVE_FROM',
	],
	"PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
	"PRICE_CODE" => [],
	"BLOCK_TITLE" => Loc::getMessage('RS.B2BPORTAL.DOCS.FILTER_TITLE'),
	"PROPERTY_TYPE_PLACEHOLDER" => Loc::getMessage('RS.B2BPORTAL.DOCS.FILTER_PROPERTY_TYPE_PLACEHOLDER')
];

$componentSorterParams = [
	'SORT_FIELDS' => $arParams['SORT_FIELDS'],
	'SORT_DEFAULT_FIELD' => $arParams['SORT_DEFAULT_FIELD'],
	'SORT_DEFAULT_ORDER' => $arParams['SORT_DEFAULT_ORDER'],
	'PERPAGE_FIELDS' => $arParams['PERPAGE_FIELDS'],
	'PERPAGE_DEFAULT' => $arParams['PERPAGE_DEFAULT'],
];

$componentNewsListParams = array_merge($componentNewsListParams, $componentSorterParams);

$this->SetViewTarget('catalog_filter');

$APPLICATION->IncludeComponent(
	'redsign:b2bportal.catalog.filter',
	'',
	$componentFilterParams
);

$this->endViewTarget();

global $USER, ${$componentNewsListParams['FILTER_NAME']};
${$componentNewsListParams['FILTER_NAME']}['PROPERTY_OWNER_ID'] = $USER->getId();
?>

<?php if ($arParams['USE_FILTER'] == 'Y'): ?>
<div class="row">

	<div class="col-12 col-xl-9">
		<?$APPLICATION->IncludeComponent(
			'redsign:b2bportal.news.list',
			'docs',
			$componentNewsListParams,
			$component,
			['HIDE_ICONS' => 'Y']
		);?>
	</div>

	<div class="col-12 col-xl-3">
		<?php $APPLICATION->ShowViewContent('catalog_filter'); ?>
	</div>
</div>

<?php else: ?>

<div class="row">
	<div class="col-12">
		<?$APPLICATION->IncludeComponent(
			'redsign:b2bportal.news.list',
			'docs',
			$componentNewsListParams,
			$component,
			['HIDE_ICONS' => 'Y']
		);?>
	</div>
</div>

<?php endif; ?>
