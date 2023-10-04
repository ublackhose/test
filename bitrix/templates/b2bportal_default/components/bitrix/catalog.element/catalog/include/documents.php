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


if (empty($arParams['PROPERTY_CODE']))
    return;

$skipProps = array_merge([], $arParams['LINES_PROPERTIES']);

$teh_doc_src  = $arResult["teh_doc_path"];
$teh_doc_name = $arResult["teh_doc_name"];
$catalog_name = $arResult["catalog_name"];
$catalog_name2 = $arResult["catalog_name2"];
$doc = new Portlet();




if(!$teh_doc_src && !$teh_doc_name && !$catalog_name && !$catalog_name2 ){
    return;
}

$doc->head(new Portlet\Head(function () {

    /** @var Portlet\Head $this */
    $this->title(function () {
        echo "Документы";
    });
}));



$body = $doc->body(function () use ($teh_doc_src, $teh_doc_name,$catalog_name,$catalog_name2) {



    foreach ($teh_doc_src as $key =>$item){
        ?>

        <a class="mt-4"  target="_blank" href="<?=$item?>">
            <?=$teh_doc_name[$key]?>
        </a>

        <?php
    }

    if($catalog_name){
        ?>
        <a class="mt-4" target="_blank"  href="<?=$catalog_name?>">
            Каталог
        </a>
        <?php
    }

    if($catalog_name2){
        ?>
        <a class="mt-4" target="_blank"  href="<?=$catalog_name2?>">
            Каталог
        </a>
        <?php
    }

    ?>


    <?php
});

$doc->render();
