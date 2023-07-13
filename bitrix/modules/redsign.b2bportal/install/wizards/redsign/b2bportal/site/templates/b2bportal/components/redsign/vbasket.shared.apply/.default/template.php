<?php

use Redsign\B2BPortal\UI\Portlet;
use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var Redsign\Components\VBasketSharedApply $component
 * @var array $arParams
 * @var array $arResult
 * @var array $globalState
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$blockId = 'rs_vsa_' . $this->randString(5);

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($arResult) {

	/** @var Portlet\Head $this */
	$this->title(function () use ($arResult) {
		echo $arResult['BASKET_DATA']['NAME'];
	});

	$this->toolbar(function () {
		echo '<div id="actions"></div>';
	});
}));

$portlet->body(function () use ($blockId) {
	echo '<div id="' . $blockId . '"></div>';
})->addModifier('fit');

$portlet->foot(new Portlet\Foot(function () use ($arResult) {

	/** @var Portlet\Foot $this */
	$this->toolbar(function () use ($arResult) {

		$sumTitle = Loc::getMessage('RS_VSA_BASKET_SUMMARY', ['#SUM_PRICE#' => $arResult['SUMMARY']['PRICE_FORMATTED']]);
		$btnTitle = Loc::getMessage('RS_VSA_BASKET_SAVE');

		echo <<<EOL
			<form method="POST">
				<input type="hidden" name="confirm" value="Y">
				<div id="actions" class="d-flex align-items-center">
					<span class="mr-3">{$sumTitle}</span>
					<button type="submit" class="btn btn-primary">{$btnTitle}</button>
				</div>
			</form>
EOL;
	});
}));

$portlet->render();
?>
<script>
	const columns = <?=\Bitrix\Main\Web\Json::encode($arResult['COLUMNS'])?>;
	const rows = <?=\Bitrix\Main\Web\Json::encode($arResult['ROWS'])?>;

	new Vue({
		el: document.getElementById('<?=$blockId?>'),

		components: {
			VueTable: B2BPortal.Vue.Components.VueTable,
		},

		data()
		{
			return { columns, rows }
		},

		template: `
			<VueTable
			 	:columns="columns"
				:rows="rows"
			>
				<template slot="table-row" slot-scope="props">
					<template v-if="props.column.field == 'NAME'">
						<div class="mb-2">

							<span class="mr-2">
								<a v-if="props.row.DETAIL_PAGE_URL" :href="props.row.DETAIL_PAGE_URL" target="_blank">{{ props.row.NAME }}</a>
								<span v-else>{{ props.row.NAME }}</span>
							</span>

						</div>

					</template>
					<template v-if="props.column.field == 'PRICE'">
						<div class="text-nowrap mr-3" v-html="props.row.PRICE_FORMATTED"></div>
					</template>
					<template v-if="props.column.field == 'QUANTITY'">
						<div class="text-nowrap mr-3">{{ props.row.QUANTITY }} {{props.row.MEASURE}}</div>
					</template>
					<template v-if="props.column.field == 'SUM_PRICE'">
						<div class="text-nowrap mr-3" v-html="props.row.SUM_PRICE_FORMATTED"></div>
					</template>
				</template>
			</VueTable>
		`
	});
</script>