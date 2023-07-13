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


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if ($request->isAjaxRequest())
{
	if (SITE_CHARSET != 'utf-8')
	{
		$_REQUEST = $APPLICATION->ConvertCharsetArray($_REQUEST, 'utf-8', SITE_CHARSET);
		$_FILES = $APPLICATION->ConvertCharsetArray($_FILES, 'utf-8', SITE_CHARSET);
	}

	if (isset($_FILES['file']))
	{
		unset($_FILES['file']);
	}
}

$APPLICATION->IncludeComponent(
	"bitrix:support.ticket.edit",
	"",
	array(
		"ID" => $arResult["VARIABLES"]["ID"],
		"TICKET_LIST_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_list"],
		"TICKET_EDIT_TEMPLATE" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["ticket_edit"],
		"MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
		"MESSAGE_SORT_ORDER" => $arParams["MESSAGE_SORT_ORDER"],
		"MESSAGE_MAX_LENGTH" => $arParams["MESSAGE_MAX_LENGTH"],
		"SET_PAGE_TITLE" => $arParams["SET_PAGE_TITLE"],
		'SHOW_COUPON_FIELD' => $arParams['SHOW_COUPON_FIELD'],
		"SET_SHOW_USER_FIELD" => $arParams["SET_SHOW_USER_FIELD"],
		"ORDER_PATH" => $arParams['ORDER_PATH']
	),
	$component,
	array('HIDE_ICONS' => 'Y')
);
