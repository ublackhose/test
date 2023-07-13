<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponent $component
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
            'rows' => $arResult['PREPARED_ROWS'],
            'pagination' => $arResult['PREPARED_PAGINATION'],
        ]
    ];

    // $component->AbortResultCache();
    $APPLICATION->RestartBuffer();
    echo \CUtil::PhpToJSObject($jsonData);
    \CMain::FinalActions();
    die();
}
