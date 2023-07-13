<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (empty($arResult['DETAIL_TEXT']))
    return;

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () {

    /** @var Portlet\Head $this */
    $this->title(function () {
        echo Loc::getMessage('RS.B2BPORTAL.TAB.DETAIL_TEXT');
    });
}));

$body = $portlet->body(function () use ($arResult) {
    echo $arResult['DETAIL_TEXT'];
});

$portlet->render();
