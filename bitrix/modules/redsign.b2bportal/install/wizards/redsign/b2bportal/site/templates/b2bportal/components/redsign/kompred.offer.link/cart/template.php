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
<div id="<?=$blockId?>" class="mr-2" style="display: <?=$arResult['VISIBLE'] ? 'block' : 'none';?>;">
	<a href="<?=$arParams['CREATE_URL']?>" target="_blank" class="btn btn-default btn-icon" title="<?=Loc::getMessage('RS_KP_KOL_T_TITLE')?>">
		<i class="flaticon2-paper"></i>
	</a>
</div>
<script>
(function () {

	var block = document.getElementById('<?=$blockId?>');
	var store = B2BPortal.store;

	B2BPortal.store.subscribe(BX.debounce(function (mutation, state) {
		if (mutation.type === 'cart/UPDATE_STATUS' && mutation.payload !== 'fetching')
		{
			BX.ajax.runComponentAction('redsign:kompred.offer.link', 'check', { mode: 'class' })
				.then(function(result) {
					block.style.display = result.data ? 'block' : 'none';
				});
		}
	}, 500));
}());
</script>