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
<div class="kt-portlet">
	<div class="kt-portlet__body">
		<div class="kt-blog-post">
			<div class="kt-blog-post__meta">
				<div class="kt-blog-post__date mb-3"><?=$arResult['DISPLAY_ACTIVE_FROM']?></div>
			</div>
			<div class="kt-blog-post__hero-image mb-3">
				<img src="<?=$arResult['DETAIL_PICTURE']['SAFE_SRC']?>" class="img-fluid kt-blog-post__image">
			</div>
			<div class="row">
				<div class="col-12 col-md-9">
					<div class="kt-blog-post__content mb-3 b-news-detail__body"><?=$arResult['DETAIL_TEXT']?></div>
				</div>
			</div>
			<div><a class="btn btn-default" href="<?=$arParams['IBLOCK_URL']?>">&larr; <?=Loc::getMessage('GO_BACK')?></a></div>
		</div>
	</div>
</div>
