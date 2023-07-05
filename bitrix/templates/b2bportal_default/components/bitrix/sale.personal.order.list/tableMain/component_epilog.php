<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixPersonalOrderListComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest())
{
    $jsonData = [
        'data' => [
            'rows' => $arResult['ROWS'],
            'pagination' => $arResult['NAV_OPTIONS'],
        ]
    ];

    // $component->AbortResultCache();
    $APPLICATION->RestartBuffer();
    echo \CUtil::PhpToJSObject($jsonData);
    \CMain::FinalActions();
    die();
}
