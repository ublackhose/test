<?php

use Bitrix\Main\Web\Uri;

/**
 * @var CMain $APPLICATION
 * @var RedsignKompredOfferList $component
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

    $uri = new Uri($request->getRequestUri());
    $uri->deleteParams(\Bitrix\Main\HttpRequest::getSystemParameters());

    /** @var Bitrix\Main\UI\PageNavigation $pageNav */
    $pageNav = $templateData['PAGINATION_OBJECT'];

    $ajaxResponse = new Bitrix\Main\Engine\Response\AjaxJson([
        'url' => $uri->getUri(),
        'items' => $templateData['ITEM_ROWS'],
        'pagination' => $templateData['PAGINATION'],
    ]);

    CMain::FinalActions($ajaxResponse->getContent());
    die();
}
