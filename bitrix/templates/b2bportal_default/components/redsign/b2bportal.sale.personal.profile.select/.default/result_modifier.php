<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (empty($arResult['PERSON_TYPES']) || empty($arResult['PROFILES']))
    return;

$arTypeIds = [];
foreach ($arResult['PROFILES'] as $profile) {
    $arTypeIds[] = $profile['PERSON_TYPE_ID'];
}

foreach ($arResult['PERSON_TYPES'] as $key1 => $arType) {
    if (in_array($arType['ID'], $arTypeIds)) {
        $arResult['PERSON_TYPES'][$key1]['HAVE_PROFILE'] = true;
    } else {
        $arResult['PERSON_TYPES'][$key1]['HAVE_PROFILE'] = false;
    }
}
