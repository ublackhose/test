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
	"redsign:b2bportal.support.ticket.list",
	"",
	array(
		"TICKET_EDIT_TEMPLATE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_edit"],
		"TICKETS_PER_PAGE" => $arParams["TICKETS_PER_PAGE"],
		"SET_PAGE_TITLE" => 'N',
		"TICKET_ID_VARIABLE" => $arResult["ALIASES"]["ID"],
		"SITE_ID" => $arParams["SITE_ID"],
		"SET_SHOW_USER_FIELD" => $arParams["SET_SHOW_USER_FIELD"],
		"AJAX_ID" => $arParams["AJAX_ID"]
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
