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
	'redsign:kompred.offer.create',
	'',
	array(
		'EDIT_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['edit'],
		'DOWNLOAD_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['download'],
		'MAKE_SHORTLINK' => $arParams['MAKE_SHORTLINK'],
		'DEFAULT_LOGO' => $arParams['DEFAULT_LOGO'],
		'DEFAULT_CONTACTS' => $arParams['~DEFAULT_CONTACTS']
	)
);
