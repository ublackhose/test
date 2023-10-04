<?php

use Bitrix\Main\Loader;
use Redsign\B2BPortal\Iblock\PropertyFeature;

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
$arParams = $component->applyTemplateModifications();

if (Loader::includeModule('redsign.b2bportal'))
{
    if (PropertyFeature::isEnabledFeatures())
    {
        $arParams['PROP_CODE_ARTICLE'] = PropertyFeature::getFirstArticlePropertyCode(
            $arParams['IBLOCK_ID'],
            ['CODE' => 'Y']
        );
        $arParams['PROP_CODE_BRAND'] = PropertyFeature::getFirstBrandPropertyCode(
            $arParams['IBLOCK_ID'],
            ['CODE' => 'Y']
        );

        $catalog = CCatalogSku::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
        if ($catalog['IBLOCK_ID'])
        {
            $arParams['OFFERS_PROP_CODE_ARTICLE'] = PropertyFeature::getFirstArticlePropertyCode(
                $catalog['IBLOCK_ID'],
                ['CODE' => 'Y']
            );
        }
        else
        {
            $arParams['OFFERS_PROP_CODE_ARTICLE'] = '-';
        }

        $component = $this->getComponent();
        $component->arParams['PROP_CODE_ARTICLE'] = $arParams['PROP_CODE_ARTICLE'];
        $component->arParams['OFFERS_PROP_CODE_ARTICLE'] = $arParams['OFFERS_PROP_CODE_ARTICLE'];
        $component->arParams['PROP_CODE_BRAND'] = $arParams['PROP_CODE_BRAND'];
    }
}

if (!isset($arParams['MAX_QUANTITY']))
    $arParams['MAX_QUANTITY'] = 500;

if (isset($arParams['~RELATIVE_QUANTITY_FACTOR']) && 0 >= $arParams['~RELATIVE_QUANTITY_FACTOR'])
    $arParams['RELATIVE_QUANTITY_FACTOR'] = 0;

if (!isset($arParams['STORAGE_PREFIX']))
    $arParams['STORAGE_PREFIX'] = 'catalog_section';

$arParams['USE_EXPORT'] = $arParams['USE_EXPORT'] === 'Y';

$arParams['EXPORT_TYPES'] = array_filter(($arParams['EXPORT_TYPES'] ?? []), function ($type) {
    return in_array($type, ['ods', 'xlsx', 'csv']);
});
