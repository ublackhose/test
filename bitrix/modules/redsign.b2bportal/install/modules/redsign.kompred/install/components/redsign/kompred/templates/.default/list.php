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


$APPLICATION->IncludeComponent(
	"redsign:kompred.offer.list",
	"",
	array(
		'PAGE_SIZE' => $arParams['LIST_PAGE_SIZE'],
		'USE_SEARCH' => $arParams['LIST_USE_SEARCH'],
		'DATE_FORMAT' => $arParams['LIST_DATE_FORMAT'],
		'EDIT_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['edit'],
		'DOWNLOAD_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['download']
	)
);
