<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


echo \Bitrix\Main\Web\Json::encode([
	'perPage' => (int) $arResult['NavPageSize'],
	'navName' => 'PAGEN_' . $arResult['NavNum'],
	'currentPage' => (int) $arResult['NavPageNomer'],
	'totalRecords' => (int) $arResult['NavRecordCount'],
]);
