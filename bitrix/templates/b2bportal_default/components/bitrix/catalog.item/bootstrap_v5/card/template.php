<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */
?>
<!---->
<?//
//echo "<pre>".print_r($item)."</pre>";
//?>
<div class="kt-blog-grid">
    <?
    $bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
    ?>
    <div class="kt-blog-grid__head">
        <a href="<?=$item['DETAIL_PAGE_URL']?>" class="kt-blog-grid__thumb-link"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" title="<?=$imgTitle?>" class="img-fluid kt-blog-grid__image"></a>
    </div>

    <div class="kt-portlet__body">
        <div class="kt-blog-grid__body">
            <div class="kt-blog-grid__date"><p><?=$item['DATE_CREATE']?></p></div>
            <div class="mb-2"><a href="<?=$item['DETAIL_PAGE_URL']?>" class="kt-blog-grid__title h4"><?=$item['NAME']?></a></div>
            <div class="kt-blog-grid__content"><p>
                    <?=$item['PREVIEW_TEXT']?>
                </p></div>
        </div>
    </div>
</div>

