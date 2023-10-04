<?php

use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


/** @var CMain $APPLICATION */
global $APPLICATION;
$aMenuLinksExt = [];

if (Loader::includeModule('iblock'))
{
    $arFilter = [
        'ACTIVE' => 'Y',
        'SITE_ID' => SITE_ID,
        'TYPE' => 'catalog',
        'ID' => '5',
    ];

    $dbIBlock = \CIBlock::GetList(['SORT' => 'ASC', 'ID' => 'ASC'], $arFilter);
    $dbIBlock = new \CIBlockResult($dbIBlock);

    if ($arIBlock = $dbIBlock->GetNext()) {
        if (defined('BX_COMP_MANAGED_CACHE')) {
            $GLOBALS['CACHE_MANAGER']->RegisterTag('iblock_id_'.$arIBlock['ID']);
        }

        if ($arIBlock['ACTIVE'] == 'Y') {
            $aMenuLinksExt = $APPLICATION->IncludeComponent(
                'bitrix:menu.sections',
                '',
                [
                'IS_SEF' => 'Y',
                'SEF_BASE_URL' => '',
                'SECTION_PAGE_URL' => $arIBlock['SECTION_PAGE_URL'],
                'DETAIL_PAGE_URL' => $arIBlock['DETAIL_PAGE_URL'],
                'IBLOCK_TYPE' => $arIBlock['IBLOCK_TYPE_ID'],
                'IBLOCK_ID' => $arIBlock['ID'],
                'DEPTH_LEVEL' => '1',
                'CACHE_TYPE' => 'N',
                ],
                false,
                ['HIDE_ICONS' => 'Y']
            );
        }
    }

    if (defined('BX_COMP_MANAGED_CACHE')) {
        $GLOBALS['CACHE_MANAGER']->RegisterTag('iblock_id_new');
    }
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
