<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


/** @var RSB2BPortalCatalogSectionComponent */
$component = $this->getComponent();
$component->arParams['PRODUCT_DISPLAY_MODE'] = 'N';
$arParams = $component->applyTemplateModifications();
