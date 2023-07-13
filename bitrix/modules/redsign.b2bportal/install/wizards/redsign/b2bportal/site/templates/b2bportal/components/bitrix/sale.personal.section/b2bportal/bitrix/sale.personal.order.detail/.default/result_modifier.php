<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (isset($arParams['USE_CLAIMS']) && $arParams['USE_CLAIMS'] == 'Y')
{
    $arResult['ADD_CLAIM_PATH'] = CComponentEngine::makePathFromTemplate(
        $arParams['ADD_CLAIM_PATH'],
        array(
            'ORDER_NUMBER' => urlencode(urlencode($arResult['ACCOUNT_NUMBER']))
        )
    );

    $arResult['CLAIMS_PATH'] = CComponentEngine::makePathFromTemplate(
        $arParams['CLAIMS_PATH'],
        array(
            'ORDER_NUMBER' => urlencode(urlencode($arResult['ACCOUNT_NUMBER']))
        )
    );
}
