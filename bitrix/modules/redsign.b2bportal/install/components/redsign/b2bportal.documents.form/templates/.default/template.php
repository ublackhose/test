<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

global $APPLICATION;
if ($arResult['FORM'] === 'edit')
	$APPLICATION->SetTitle(Loc::getMessage('RS_B2B_DE_FORM_EDIT'));
else
	$APPLICATION->SetTitle(Loc::getMessage('RS_B2B_DE_FORM_NEW'));

\Bitrix\Main\UI\Extension::load([
	'ui.alerts',
	'ui.forms',
	'ui.vue'
]);

if (count($arResult['MESSAGES']['CRITICAL_ERRORS']) > 0)
{
	?>
	<div class="ui-alert ui-alert-danger">
		<span class="ui-alert-message">
			<?=implode('<br>', $arResult['MESSAGES']['CRITICAL_ERRORS'])?>
		</span>
	</div>
	<?php
}
else
{
	$blockId = 'documents_edit_form_' . $this->randString(5);

	$jsParams = [
		'form' => $arResult['FORM'],
		'siteId' => $arResult['SITE_ID'] ?? '',
		'orderId' => $arResult['ORDER_ID'],
		'userId' => $arResult['USER_ID'],
		'filledValues' => $arResult['FILLED_VALUES'],
		'propsValues' => $arResult['PROPS_VALUES']
	];

	?>

	<?php
	if (count($arResult['MESSAGES']['SAVE_ERRORS']) > 0)
	{
		?>
		<div class="ui-alert ui-alert-danger">
			<span class="ui-alert-message">
				<?=implode('<br>', $arResult['MESSAGES']['SAVE_ERRORS'])?>
			</span>
		</div>
		<?php
	}
	?>

	<?php
	if (count($arResult['MESSAGES']['SUCCESS']) > 0)
	{
		?>
		<script>
			setTimeout(function () {
				BX.SidePanel.Instance.close();
			}, 100);
		</script>
		<?php
	}
	?>

	<form method="post" enctype='multipart/form-data'>
		<?=bitrix_sessid_post()?>

		<?php if ($arResult['FORM'] === 'edit'): ?>
			<input type="hidden" name="DOC_ID" value="<?=$arResult['DOCUMENT_ID']?>" />
		<?php endif; ?>

		<div class="rs-doc-form-wrapper">
			<div id="<?=$blockId?>"></div>
		</div>

		<?$APPLICATION->IncludeComponent('bitrix:ui.button.panel', '', [
			'BUTTONS' => ['save', 'cancel' => '/']
		]);?>
	</form>

	<script>
	(function(){
		<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
		BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

		var element = document.getElementById('<?=$blockId?>');
		var params = <?=Json::encode($jsParams)?>;

		new B2BPortal.Components.DocumentsEditForm(element, params);
	}());
	</script>
	<?php
}
