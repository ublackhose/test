<?php

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

if (empty($arResult["STORES"]))
	return;

$this->addExternalJS($templateFolder . '/js/component.js');

$sBlockId = 'catalogStoreAmount' . $this->randString(6);
?>
<?php if ($arParams['MAIN_TITLE'] != ''): ?>
	<h4><?=$arParams['MAIN_TITLE']?></h4>
<?php endif; ?>

<div id="<?=$sBlockId?>-store-amount"></div>

<script>
(function () {

	new CatalogStoreAmount(
		<?=\Bitrix\Main\Web\Json::encode($arResult['STORES'])?>,
		{
			blockId: '<?=$sBlockId?>',
			arParams: <?=\Bitrix\Main\Web\Json::encode($arParams)?>,
		}
	);

}());
</script>