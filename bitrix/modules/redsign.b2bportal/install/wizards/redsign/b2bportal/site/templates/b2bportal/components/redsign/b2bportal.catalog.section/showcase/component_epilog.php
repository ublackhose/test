<?php

/**
 * @var CMain $APPLICATION
 * @var RSB2BPortalCatalogSectionComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest() || $templateData['COMP_ID'] = $request->getPost('comp_id'))
{
	$APPLICATION->RestartBuffer();
	$ajaxResponse = new Bitrix\Main\Engine\Response\AjaxJson([
		'url' => $component->getRedirectUrl(),
		'items' => $templateData['ITEM_ROWS'],
		'pagination' => $templateData['PAGINATION']
	]);
	CMain::FinalActions($ajaxResponse->getContent());
	die();
}
