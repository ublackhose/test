<?php

use Bitrix\Main\Engine\Response\Converter;
use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferEdit $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


\Bitrix\Main\Loader::includeModule('currency');

\Bitrix\Main\UI\Extension::load('currency');
\Bitrix\Main\UI\Extension::load('ui.fontawesome4');
\Bitrix\Main\UI\Extension::load('redsign.kompred.editor');

if (!empty($arResult['ERRORS']))
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm($arResult['ERRORS'][$component::ERROR_NO_ACCESS], false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
else
{
	global $APPLICATION;
	$APPLICATION->SetTitle($arResult['OFFER']['NAME']);
	$APPLICATION->AddChainItem(
		$arResult['OFFER']['NAME'],
		$arResult['OFFER']['EDIT_URL']
	);

	$randString = $this->randString();

	$baseCurrency = \Bitrix\Sale\Internals\SiteCurrencyTable::getSiteCurrency($arResult['OFFER']['SITE_ID']);
	$baseCurrencyFormat = \CCurrencyLang::GetFormatDescription($baseCurrency);

	$jsParams = [];
	$jsParams['offer'] = (Converter::toJson())->process($arResult['OFFER']);
	$jsParams['structure'] = $arResult['STRUCTURE'];
	$jsParams['config'] = [
		'defaultLogo' => '/include/logo.png'
	];

	?>

	<div class="d-flex align-items-end">

		<div class="form-group mb-3 flex-grow-1">
			<label for="offer_name_<?=$randString?>"><?=Loc::getMessage('RS_KP_KOE_T_NAME') ?></label>
			<input type="text" class="form-control" value="<?=htmlspecialcharsbx($arResult['OFFER']['NAME'])?>" id="offer_name_<?=$randString?>" placeholder="RS_KP_KOE_T_NAME_PLACEHOLDER">
		</div>

		<div class="mb-3 d-flex">
			<a href="<?=$arResult['OFFER']['DOWNLOAD_URL_SHORT'] ?? $arResult['OFFER']['DOWNLOAD_URL']?>" target="_blank" class="btn btn-outline-primary ml-1">
				<i class="fa fa-download" aria-hidden="true"></i> <?=Loc::getMessage('RS_KP_KOE_T_DOWNLOAD') ?>
			</a>
			<a
				onclick="confirm('<?=Loc::getMessage('RS_KP_KOE_T_DELETE_CONFIRM') ?>') || event.preventDefault();"
				href="<?=$arResult['OFFER']['DELETE_URL']?>"
				class="btn btn-outline-danger ml-1"
				title="<?=Loc::getMessage('RS_KP_KOE_T_DELETE') ?>"
			>
				<i class="fa fa-trash" aria-hidden="true"></i>
			</a>
		</div>
	</div>

	<div class="p-5 border rounded" id="editor"></div>

	<script>
		(function() {

			BX.Currency.setCurrencyFormat(
				'<?=$baseCurrency?>',
				<?=\CUtil::PhpToJSObject($baseCurrencyFormat)?>
			);

			var editor = new RSKomPred.Editor(
				document.getElementById('editor'),
				<?=\CUtil::PhpToJSObject($jsParams, false, false, true)?>
			);

			var nameInput = document.getElementById('offer_name_<?=$randString?>');

			var saveData = function() {
				editor.save()
					.then(function (data) {
						data.offer.name = nameInput.value;
						BX.ajax.runAction('redsign:kompred.api.offer.save', { data: data })
					});
			};

			editor.subscribe(RSKomPred.Editor.Events.CHANGED, saveData);
			nameInput.addEventListener('change', saveData);
		}());
	</script>
	<?php
}