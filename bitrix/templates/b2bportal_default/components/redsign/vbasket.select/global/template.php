<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignVBasketSelect $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!empty($arParams['CART_PATH'])) {
	$arParams['CART_PATH'] = SITE_DIR . 'personal/cart/';
}

$this->addExternalJS($templateFolder . '/js/component.js');

$blockId = 'basketGlobal_' . $this->randString(5);

?>
<div id="<?=$blockId?>"></div>
<script>
	(function () {
		new B2BPortal.Components.BasketsGlobal({
			el: document.getElementById('<?=$blockId?>'),

			baskets: <?=\Bitrix\Main\Web\Json::encode($arResult)?>,
			basketUrl: '<?=CUtil::JSEscape($arParams['CART_PATH']);?>'
		});
	})();
</script>