<?php

use Bitrix\Main\Page\AssetLocation;
use Bitrix\Main\Web\Json;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

global $globalState;

$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	"global",
	array(
		"HIDE_ON_BASKET_PAGES" => "N",
		"SHOW_DELAY" => "N",
		"SHOW_NOTAVAIL" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_PRICE" => "Y",
		"SHOW_PRODUCTS" => "Y",
		"SHOW_SUMMARY" => "Y",
		"SHOW_TOTAL_PRICE" => "Y"
	)
);

$APPLICATION->IncludeComponent(
	'redsign:vbasket.select',
	'globalstate',
	array()
);

\Bitrix\Main\Page\Asset::getInstance()->addString(
	'<script>
		window.__INITIAL_STATE__ = {
			baskets: [],
			stocks: { amounts: {}, data: {} },
			cart: {}
		}
	</script>',
	true,
	AssetLocation::AFTER_CSS
);

$dynamicArea = new \Bitrix\Main\Composite\StaticArea('global_set_state');
$dynamicArea->startDynamicArea();
?>
<script>
(function() {
	if (!window.B2BPortal || !B2BPortal.store)
		return;

	B2BPortal.store.dispatch('initialize', {
		baskets: <?=Json::encode($globalState['baskets'] ?? [])?>,
		multicart: {
			cartList: <?=Json::encode($globalState['cartList'] ?? [])?>
		},
		cart: {
			totalPrice: '<?=\CUtil::JSEscape($globalState['cart']['totalPrice'])?>',
			totalPriceRaw: <?=((float) $globalState['cart']['totalPriceRaw'])?>,
			numProducts: <?=((int) $globalState['cart']['numProducts'])?>,
			addedIds: new Set(<?=Json::encode($globalState['cart']['addedIds'])?>),
			quantityByIds: <?=Json::encode($globalState['cart']['quantityByIds'])?>,
		}
	});

}());
</script>
<?php

$dynamicArea->finishDynamicArea();