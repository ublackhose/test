<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var SaleOrderPaymentChange $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!empty($arResult["errorMessage"]))
{
	if (!is_array($arResult["errorMessage"]))
	{
		ShowError($arResult["errorMessage"]);
	}
	else
	{
		foreach ($arResult["errorMessage"] as $errorMessage)
		{
			ShowError($errorMessage);
		}
	}
}
else
{
	$wrapperId = 'bx-socp_' . $this->randString(5);
	?>
	<ul class="kt-nav" id="<?=$wrapperId?>">
		<?php foreach ($arResult['PAYSYSTEMS_LIST'] as $key => $paySystem): ?>
		<li class="kt-nav__item" data-entity="paysystem" data-paysystem-id="<?=$paySystem['ID']?>">
			<a href="#" class="kt-nav__link">
				<span class="kt-nav__link-text"><?=CUtil::JSEscape(htmlspecialcharsbx($paySystem['NAME']))?></span>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	<script>
	(function () {
		BX.message({
			'SOPC_TPL_SUM_TO_PAID': '<?=Loc::getMessage('SOPC_TPL_SUM_TO_PAID')?>',
			'SOPC_TPL_PAY_BUTTON': '<?=Loc::getMessage('SOPC_TPL_PAY_BUTTON')?>',
			'SOPC_TPL_PAY_CANCEL': '<?=Loc::getMessage('SOPC_TPL_PAY_CANCEL')?>'
		});

		new B2BPortal.SaleOrderPaymentChange(document.getElementById('<?=$wrapperId?>'), {
			ajaxPath: '<?=CUtil::JSEscape($this->__component->GetPath() . '/ajax.php')?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',
			templateName: '<?=$this->__component->GetTemplateName()?>',
			accountNumber: '<?=$arParams['ACCOUNT_NUMBER']?>',
			paymentNumber: '<?=$arParams['PAYMENT_NUMBER']?>',
			inner: '<?=$arParams['ALLOW_INNER']?>',
			onlyInnerFull: '<?=$arParams['ONLY_INNER_FULL']?>',
			refreshPrices: '<?=$arParams['REFRESH_PRICES']?>',
			pathToPayment: '<?=$arParams['PATH_TO_PAYMENT']?>',
		});
	}());
	</script>
	<?php
}
