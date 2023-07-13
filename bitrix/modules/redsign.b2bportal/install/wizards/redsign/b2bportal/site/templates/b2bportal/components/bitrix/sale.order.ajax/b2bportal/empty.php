<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var SaleOrderAjax $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="bx-soa-empty-cart-container">
	<div class="bx-soa-empty-cart-image">
		<img src="" alt="">
	</div>
	<div class="bx-soa-empty-cart-text"><?=Loc::getMessage("EMPTY_BASKET_TITLE")?></div>
	<?
	if (!empty($arParams['EMPTY_BASKET_HINT_PATH']))
	{
		?>
		<div class="bx-soa-empty-cart-desc">
			<?=Loc::getMessage(
				'EMPTY_BASKET_HINT',
				[
					'#A1#' => '<a href="' . $arParams['EMPTY_BASKET_HINT_PATH'] . '">',
					'#A2#' => '</a>',
				]
			)?>
		</div>
		<?
	}
	?>
</div>