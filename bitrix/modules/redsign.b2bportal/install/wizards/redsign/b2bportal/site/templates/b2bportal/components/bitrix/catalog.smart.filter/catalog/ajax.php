<?php

use Redsign\B2BPortal\DI;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixCatalogSmartFilter $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if ($arParams['FILTER_ENABLE_HIDE_NOT_AVAILABLE'] == 'Y')
{
    /** @var \Bitrix\Main\HttpRequest */
    $request = DI\ServiceContainer::getInstance()->get('Request');
    if (!empty($request->get('hide_not_available')))
    {
        $urlKeys = [
            'FILTER_URL',
            'FILTER_AJAX_URL',
            'SEF_DEL_FILTER_URL',
            'SEF_SET_FILTER_URL'
        ];

        foreach ($urlKeys as $key)
        {
            if (empty($arResult[$key])) continue;

            $query = parse_url($arResult[$key], PHP_URL_QUERY);

            /** @var string */
            $hideNotAvailable = $request->get('hide_not_available');
            $arResult[$key] .= ($query ? '&' : '?') . 'hide_not_available=' . $hideNotAvailable;
        }
    }
}

$APPLICATION->RestartBuffer();
unset($arResult["COMBO"]);
echo CUtil::PHPToJSObject($arResult, true);
