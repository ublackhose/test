<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

$sBlockId = 'element_detail_' . $arResult['ID'];
$componentTemplate = $this;

$jsData = [
	'blockIds' => [
		'element' => $sBlockId,
		'gallery' => $sBlockId . '_gallery'
	],
	'gallery' => [
		'items' => $arResult['GALLERY_ITEMS']
	]
];

$portlet = new Portlet();
$portlet->sticky();
$body = $portlet->body(function () use ($arResult, $arParams, $jsData, $component) {
	?>
	<div class="row">
		<div class="col-12">
			<?php include 'include/pictures.php'; ?>
		</div>
	</div>
	<?php if ($arResult['LABELS']): ?>
		<div class="row">
			<div class="col-12">
				<div class="p-2">
					<?php foreach($arResult['LABELS'] as $label): ?>
						<span class="badge badge-<?=$label['MODIFIER']?> mr-2 mb-2 label-<?=strtolower($label['CODE'])?>"><?=$label['NAME']?></span>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php
});
$portlet->render();

$this->SetViewTarget('catalog-element-data');

include 'include/properties.php';
include 'include/description.php';

?>
<script>
(function () {
	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	new CatalogElement(<?=\Bitrix\Main\Web\Json::encode($jsData)?>);

}());
</script>
<?php
$this->EndViewTarget();