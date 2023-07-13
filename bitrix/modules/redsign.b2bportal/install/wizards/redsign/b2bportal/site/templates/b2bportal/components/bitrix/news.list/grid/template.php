<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$this->setFrameMode(true);
?>

<div class="row">
    <?php
    foreach ($arResult['ITEMS'] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
    <div class="col-md-4 pb-4">
        <div class="kt-portlet kt-portlet--contain h-100" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="kt-blog-grid">
                <?php if (!empty($arItem['PREVIEW_PICTURE']['SAFE_SRC'])): ?>
                <div class="kt-blog-grid__head">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="kt-blog-grid__thumb-link"><img src="<?=$arItem['PREVIEW_PICTURE']['SAFE_SRC']?>" class="img-fluid kt-blog-grid__image"></a>
                </div>
                <?php endif; ?>
                <div class="kt-portlet__body">
                    <div class="kt-blog-grid__body">
                        <div class="kt-blog-grid__date"><p><?=$arItem['DISPLAY_ACTIVE_FROM']?></p></div>
                        <div class="mb-2"><a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="kt-blog-grid__title h4"><?=$arItem['NAME']?></a></div>
                        <div class="kt-blog-grid__content"><?=$arItem['PREVIEW_TEXT']?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
