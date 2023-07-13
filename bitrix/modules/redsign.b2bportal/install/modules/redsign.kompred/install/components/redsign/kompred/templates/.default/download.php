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
	"redsign:kompred.offer.show",
	"",
	array(
		'ID' => (int) $arResult['VARIABLES']['ID'],
		'CODE' => $arResult['VARIABLES']['CODE'] ?? '',
		'EDIT_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['edit'],
		'DOWNLOAD_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['download'],
		'PROP_VENDOR_CODE' => $arParams['PROP_VENDOR_CODE'],
	)
);
