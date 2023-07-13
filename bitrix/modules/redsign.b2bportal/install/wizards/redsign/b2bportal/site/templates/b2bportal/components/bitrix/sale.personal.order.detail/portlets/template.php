<?php

use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJs(SITE_TEMPLATE_PATH . '/assets/vendors/dragula/dragula.js');
$this->addExternalCss(SITE_TEMPLATE_PATH . '/assets/vendors/dragula/dragula.css');

$this->addExternalJs($templateFolder . '/js/component.js');

$blockId = 'sale_order_detail_' . $this->randString(5);

$renderBlock = function (string $blockName, string $title, bool $isCollapsed, callable $content) {
	$blockId = 'sale_order_detail_block_' . $blockName;

	$portlet = new Portlet();

	$portlet->dataAttributes([
		'block' => $blockName,
		'content' => $blockId,
	]);

	$portlet->addModifier('draggable');

	$portlet->head(new Portlet\Head(function () use ($title, $blockId) {

		/** @var Portlet\Head $this */
		$this->title($title);

		$this->toolbar(function () use ($blockId) {

			echo <<<EOL
				<a href="#{$blockId}" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="collapse">
					<i class="fa fa-angle-down pr-0"></i>
				</a>
EOL;
		});
	}));

	$portlet->body(function () use ($blockName, $content) {

		$isReload = isset($_REQUEST['reload_block']) && $_REQUEST['reload_block'] === $blockName;

		if ($isReload)
		{
			global $APPLICATION;
			$APPLICATION->RestartBuffer();
		}

		$content();

		if ($isReload)
		{
			die();
		}
	})->collapsible($blockId, $isCollapsed ? Portlet\Body::COLLAPSED : Portlet\Body::COLLAPSE);

	$portlet->render();
};

$block = function ($blockName) use ($templateFolder, $component, $arResult, $arParams, $renderBlock) {
	$includeFilePath = $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/blocks/' . $blockName . '.php';
	if (file_exists($includeFilePath))
	{
		include $includeFilePath;
	}
	elseif (substr($blockName, 0, strlen('order_group_')) === 'order_group_')
	{
		include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/blocks/order_props_group.php';
	}
};
?>
<div class="row">
	<div class="col-12">
		<?php include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/blocks/order.php'; ?>
	</div>
</div>
<div class="row" id="<?=$blockId?>">
	<div class="col-12 col-lg-12 col-xl-6" id="<?=$blockId?>_column_left">
		<?php
		if (isset($arResult['SORTED_BLOCKS'][0]))
		{
			foreach ($arResult['SORTED_BLOCKS'][0] as $blockName) $block($blockName);
		}
		?>
	</div>

	<div class="col-12 col-lg-12 col-xl-6" id="<?=$blockId?>_column_right">
		<?php
		if (isset($arResult['SORTED_BLOCKS'][1]))
		{
			foreach ($arResult['SORTED_BLOCKS'][1] as $blockName) $block($blockName);
		}
		?>
	</div>
</div>
<script>
(function () {

	var columns = [
		document.getElementById('<?=$blockId?>_column_left'),
		document.getElementById('<?=$blockId?>_column_right'),
	];

	new B2BPortal.SaleOrderDetail.Blocks(
		document.getElementById('<?=$blockId?>'),
		columns
	);
}())
</script>