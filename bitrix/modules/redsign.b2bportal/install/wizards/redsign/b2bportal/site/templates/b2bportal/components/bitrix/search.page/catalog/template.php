<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


Portlet::simple(Loc::getMessage('SEARCH_PAGE_BLOCK_TITLE'), function () use ($arResult) {
	?>
	<div class="row">
		<div class="col-md-12">
			<form action="" method="get">
				<input type="hidden" name="how" value="<?=$arResult["REQUEST"]["HOW"] == "d" ? "d" : "r"?>" />
				<div class="input-group">
					<input type="text" class="form-control" name="q" value="<?=$arResult["REQUEST"]["QUERY"]?>" size="40" />
					<div class="input-group-append">
						<input class="btn btn-primary" type="submit" value="<?=Loc::getMessage("SEARCH_GO")?>" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
})->render();