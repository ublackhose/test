<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferLink $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$blockId = 'offer_link_' . $this->randString(5);
?>
<div class="mb-4" id="<?=$blockId?>" style="display: <?=$arResult['VISIBLE'] ? 'block' : 'none';?>;">
	<a href="<?=$arParams['CREATE_URL']?>" class="btn btn-primary btn-sm">
		<?=Loc::getMessage('RS_KP_KOL_T_TITLE')?>
	</a>
</div>
<script>
(function () {

	var block = document.getElementById('<?=$blockId?>');
	BX.addCustomEvent('OnBasketChange', function() {
		BX.ajax.runComponentAction('redsign:kompred.offer.link', 'check', { mode: 'class' })
			.then(function(result) {
				block.style.display = result.data ? 'block' : 'none';
			});
	});

}());
</script>