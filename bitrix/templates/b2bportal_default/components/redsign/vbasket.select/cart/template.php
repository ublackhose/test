<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignVBasketSelect $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var array $globalState
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');

$useSharing = \Bitrix\Main\Config\Option::get('redsign.vbasket', 'use_sharing');
?>

<div class="row">
	<div class="col-md-12">
		<?php
		$portlet = new Portlet();

		$portlet->body(function () {
			echo '<div id="basket-select"></div>';
		});

		$portlet->render();
		?>
	</div>
</div>

<script>

<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
BX.message(<?=CUtil::PhpToJSObject($messages)?>);

new B2BPortal.Components.BasketSelect(
	document.querySelector('#basket-select'),
	{
		useSharing: <?=$useSharing === 'Y' ? 'true' : 'false';?>,
	}
);
</script>