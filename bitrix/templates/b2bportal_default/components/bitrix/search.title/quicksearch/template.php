<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

$this->addExternalJs($templateFolder . '/dist/component.js');

$inputId = trim($arParams["~INPUT_ID"]);
if (!mb_strlen($inputId))
	$inputId = 'title-search-input';

$jsParams = [
	'action' => $arResult['FORM_ACTION'],
	'ajaxUrl' => POST_FORM_ACTION_URI,
	'minLength' => 3,
	'inputId' => $inputId,
	'inputName' => 'q'
];

?>
<div id="<?=$arParams['CONTAINER_ID']?>"></div>

<script>
(function () {
	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	new B2BPortal.Components.QuickSearch(
		document.getElementById('<?=$arParams['CONTAINER_ID']?>'),
		<?=\CUtil::PhpToJSObject($jsParams, false, false, true)?>
	);
}());
</script>