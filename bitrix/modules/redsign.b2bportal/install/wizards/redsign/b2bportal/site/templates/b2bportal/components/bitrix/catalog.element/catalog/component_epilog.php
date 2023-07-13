<?php

use Bitrix\Main\UI\Extension;

/**
 * @var CMain $APPLICATION
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Extension::load('redsign.b2bportal.photoswipe');

global $catalogElement;
$catalogElement = [
    'LINES_PROPERTIES' => []
];

// Lines properties
if (!empty($arParams['LINES_PROPERTIES']) && is_array($arParams['LINES_PROPERTIES'])) {
    foreach ($arParams['LINES_PROPERTIES'] as $propCode) {
        if (!isset($arResult['DISPLAY_PROPERTIES'][$propCode]))
            continue;

        $catalogElement['LINES_PROPERTIES'][$propCode] = $arResult['DISPLAY_PROPERTIES'][$propCode];
    }
}

foreach ($arResult['DISPLAY_PROPERTIES'] as $displayPropertyCode => $displayProperty) {
    if (
        $displayProperty['USER_TYPE'] == 'redsign_custom_filter' &&
        !isset($catalogElement['LINES_PROPERTIES'][$displayPropertyCode])
    ) {
        $catalogElement['LINES_PROPERTIES'][$displayPropertyCode] = $displayProperty;
    }
}
