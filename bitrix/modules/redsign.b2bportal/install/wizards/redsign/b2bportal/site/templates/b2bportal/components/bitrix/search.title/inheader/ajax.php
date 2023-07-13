<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

?>

<?php if(!empty($arResult["CATEGORIES"]) && $arResult['CATEGORIES_ITEMS_EXISTS']): ?>
<div class="kt-quick-search kt-quick-search--inline kt-quick-search--result-compact kt-quick-search--has-result show" id="kt_quick_search_inline">
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-lg show position-relative" x-placement="bottom-end">
        <div class="kt-quick-search__wrapper kt-scroll ps ps--active-y" data-scroll="true" data-height="325" data-mobile-height="200" style="max-height: 325px; overflow: hidden;">
            <div class="kt-quick-search__result">
            <?php foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
                <div class="kt-quick-search__category">
                    <?=$arCategory['TITLE']?>
                </div>
                <div class="kt-quick-search__section mb-0">
                <?php
                foreach($arCategory["ITEMS"] as $i => $arItem):
                    if ($arItem['TYPE'] == 'all') continue;

                    if (isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
                        $arCatalogItem = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
                        ?>
                        <div class="kt-quick-search__item">
                            <div class="kt-quick-search__item-img kt-quick-search__item-img--file">
                                <?php if (is_array($arCatalogItem['PICTURE'])): ?>
                                    <img src="<?=$arCatalogItem["PICTURE"]["src"]?>" alt="">
                                <?php else: ?>
                                    <img src="<?=$templateFolder?>/images/no_photo.png" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="kt-quick-search__item-wrapper">
                                <a href="<?=$arItem["URL"]?>" class="kt-quick-search__item-title">
                                    <?=$arItem["NAME"]?>
                                </a>

                                <?php if (!empty($arCatalogItem['MIN_PRICE'])): ?>
                                    <div class="kt-quick-search__item-desc">
                                        <?=Loc::getMessage('CT_BST_PRICE_FROM');?>
                                        <?=$arCatalogItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"]?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif;