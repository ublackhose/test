<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixBasketComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


Loader::includeModule('redsign.b2bportal');

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
if ($request->getQuery('export') && in_array($request->getQuery('export'), ['csv', 'ods', 'xlsx', 'xls']))
{
	include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/spreadsheet.php';
	return;
}

$this->addExternalJs(SITE_TEMPLATE_PATH . '/assets/vendors/vue/vue.js');
$this->addExternalJS($templateFolder . '/js/component.js');

if (!isset($arParams['SHOW_QUANTITY']))
{
	$arParams['SHOW_QUANTITY'] = 'Y';
}

if (!isset($arParams['RELATIVE_QUANTITY_FACTOR']))
{
	$arParams['RELATIVE_QUANTITY_FACTOR'] = 100;
}
elseif (isset($arParams['~RELATIVE_QUANTITY_FACTOR']) && 0 >= $arParams['~RELATIVE_QUANTITY_FACTOR'])
{
	$arParams['RELATIVE_QUANTITY_FACTOR'] = 0;
}

$arParams['MAX_QUANTITY'] = $arParams['MAX_QUANTITY'] ?? 500;

$arParams['MESS_RELATIVE_QUANTITY_MANY'] = empty($arParams['MESS_RELATIVE_QUANTITY_MANY']) ?
	Loc::getMessage('RS_B2B_SBB_RELATIVE_QUANTITY_MANY') : $arParams['MESS_RELATIVE_QUANTITY_MANY'];

$arParams['MESS_RELATIVE_QUANTITY_FEW'] = empty($arParams['MESS_RELATIVE_QUANTITY_FEW']) ?
	Loc::getMessage('RS_B2B_SBB_RELATIVE_QUANTITY_FEW') : $arParams['MESS_RELATIVE_QUANTITY_FEW'];

$arParams['MESS_RELATIVE_QUANTITY_NO'] = empty($arParams['MESS_RELATIVE_QUANTITY_NO']) ?
	Loc::getMessage('RS_B2B_SBB_RELATIVE_QUANTITY_NO') : $arParams['MESS_RELATIVE_QUANTITY_NO'];

$elementId = 'basketTable_' . $this->randString(5);

$portlet = new Portlet();
$portlet->head(new Portlet\Head(function () use ($elementId, $arResult, $arParams, $component) {

	/** @var Portlet\Head $this */
	$this->title(function () {
		?>
		<div class="kt-input-icon kt-input-icon--left">
			<input type="text" class="form-control" placeholder="<?=Loc::getMessage('SBB_SEARCH');?>" id="cartSearchInput">
			<span class="kt-input-icon__icon kt-input-icon__icon--left">
				<span><i class="la la-search"></i></span>
			</span>
		</div>
		<?
	});

	$this->toolbar(function () use ($elementId, $arResult, $arParams, $component) {

		?><div class="d-flex">

			<?php
			if (Loader::includeModule('redsign.kompred'))
			{
				global $APPLICATION;
				$APPLICATION->IncludeComponent(
					"redsign:kompred.offer.link",
					"cart",
					array(
						'CREATE_URL' => $arParams['KOMPRED_CREATE_URL']
					),
					$component,
					['HIDE_ICONS' => 'Y']
				);
			}
			?>

			<a href="<?=$arResult['PDF_PATH']?>" id="pdflink_<?=$elementId?>" class="btn btn-default btn-icon mr-2" target="_blank" title="<?=Loc::getMessage('SBB_PDF_LINK');?>"><i class="flaticon2-print"></i></a>
			<div id="<?=$elementId?>_actionsHead"></div>
		</div>
		<?php
	});
}));

$portlet->foot(new Portlet\Foot(function () use ($elementId) {

	/** @var Portlet\Foot $this */
	$this->toolbar(function () use ($elementId) {
		echo '<div id="' . $elementId . '_actionsFoot"></div>';
	});
}));

$portlet->body(function () use ($elementId) {
	echo '<div id="' . $elementId . '"></div>';
})->addModifier('fit');

?><div id="<?=$elementId?>_block"><?
$portlet->render();
?></div><?

$signer = new \Bitrix\Main\Security\Sign\Signer();
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
$messages = Loc::loadLanguageFile(__FILE__);

$this->SetViewTarget('basket-summary');
?>
<div id="<?=$elementId?>_summary"></div>

<script>
	(function () {

		BX.message(<?=CUtil::PhpToJSObject($messages)?>);

		new B2BPortal.Components.Basket({
			elementId: '<?=$elementId?>',
			searchInput: document.getElementById('cartSearchInput'),

			columns: <?=\Bitrix\Main\Web\Json::encode($arResult['COLUMNS'])?>,
			rows: <?=\Bitrix\Main\Web\Json::encode($arResult['ROWS'])?>,
			summary: <?=\Bitrix\Main\Web\Json::encode($arResult['SUMMARY'])?>,
			discountList: <?=\Bitrix\Main\Web\Json::encode($arResult['BASKET_DATA']['FULL_DISCOUNT_LIST'])?>,

			useStocks: <?=$arParams['USE_STORE'] === 'Y' ? 'true' : 'false'; ?>,
			displayStocks: <?=\Bitrix\Main\Web\Json::encode($arParams['STORES'])?>,

			showQuantity: <?=$arParams['SHOW_QUANTITY'] !== 'N' ? 'true' : 'false';?>,
			<?php if ($arParams['SHOW_QUANTITY'] !== 'N'): ?>
			quantityDisplayMode: <?=$arParams['SHOW_QUANTITY'] === 'M' ? 2 : 1; ?>,
			quantityRelativeFactor: <?=$arParams['RELATIVE_QUANTITY_FACTOR']?>,
			quantityMessages: {
				'RELATIVE_QUANTITY_MANY': '<?=$arParams['MESS_RELATIVE_QUANTITY_MANY']?>',
				'RELATIVE_QUANTITY_FEW': '<?=$arParams['MESS_RELATIVE_QUANTITY_FEW']?>',
				'RELATIVE_QUANTITY_NO': '<?=$arParams['MESS_RELATIVE_QUANTITY_NO']?>'
			},
			maxQuantity: <?=CUtil::JSEscape($arParams['MAX_QUANTITY'])?>,
			<?php endif; ?>

			signedParameters: '<?=CUtil::JSEscape($signedParams)?>',
			template: '<?=CUtil::JSEscape($signedTemplate)?>',
			actionVariable: '<?=CUtil::JSEscape($arParams['ACTION_VARIABLE'])?>',
			ajaxUrl: '<?=CUtil::JSEscape($arParams['AJAX_PATH'])?>',
			siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
			siteTemplateId: '<?=CUtil::JSEscape($component->getSiteTemplateId())?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>',

			pathToOrder: '<?=CUtil::JSEscape($arParams['PATH_TO_ORDER'])?>',
			exportTypes: <?=\Bitrix\Main\Web\Json::encode($arResult['EXPORT_TYPES'])?>,
		});

	}());
</script>

<?php
$this->EndViewTarget();
