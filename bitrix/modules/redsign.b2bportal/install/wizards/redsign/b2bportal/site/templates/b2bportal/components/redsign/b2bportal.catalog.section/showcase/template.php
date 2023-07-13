<?php

use Bitrix\Main\Engine\Response\Converter;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalCatalogSectionComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$converter = Converter::toJson();

$randString = $this->randString();
$uniqueString = md5($randString . $component->getAction());
$compId = 'cs_' . $randString;

$itemRows = [];
foreach ($arResult['ITEMS'] as $item)
{
	$uniqueId = $item['ID'] . '_' . $uniqueString;
	$areaId = $this->GetEditAreaId($uniqueId);

	$imgAlt = $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'] ?? $item['NAME'];
	$imgTitle = $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] ?? $item['NAME'];
	$imgSrc = $item['PREVIEW_PICTURE']['SRC'] ?? $templateFolder . '/images/noimg.jpg';

	$itemRow = [
		'areaId' => $areaId,
		'name' => $item['NAME'],
		'url' => $item['DETAIL_PAGE_URL'],
		'preview' => $imgSrc,
		'previewAlt' => $imgAlt,
		'previewTitle' => $imgTitle,
		'priceStart' => $item['ITEM_START_PRICE'] ? $converter->process($item['ITEM_START_PRICE']) : false,
		'products' => [],

		'menu' => [
			'edit' => $item['EDIT_LINK'],
			'delete' => $item['DELETE_LINK']
		]
	];

	if (!empty($item['OFFERS']))
	{
		$itemRow['selected'] = (int) $item['OFFERS_SELECTED'];

		foreach ($item['OFFERS'] as $id => $product)
		{
			$itemRow['products'][] = [
				'name' => $product['NAME'],
				'prices' => $converter->process($product['ITEM_PRICES']),
				'priceSelected' => $product['ITEM_PRICE_SELECTED']
			];
		}
	}
	else
	{
		$itemRow['selected'] = 0;

		$itemRow['products'][] = [
			'name' => $item['NAME'],
			'prices' => $converter->process($item['ITEM_PRICES']),
			'priceSelected' => $item['ITEM_PRICE_SELECTED']
		];
	}

	$itemRows[] = $itemRow;
}
unset($itemRow);

$pagination = [
	'paramName' => 'PAGEN_' . $arResult['NAV_RESULT']->NavNum,
	'currentPage' => (int) $arResult['NAV_RESULT']->NavPageNomer,
	'pageCount' => (int) $arResult['NAV_RESULT']->NavPageCount,
	'perPage' => (int) $arParams['PAGE_ELEMENT_COUNT'],
	'perPageOptions' => $arParams['CATALOG_SORTER']['PERPAGE_DROPDOWN']
];


$blockIds = [
	'section' => 'cs_' . $randString,
	'items' => 'cs_items_' . $randString,
	'pagination' => 'cs_pagination_' . $randString
];

$iblockData = [
	'messages' => [
		'element_edit' => \CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'),
		'element_delete' => \CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE')
	]
];

$templateData['COMP_ID'] = $compId;
$templateData['ITEM_ROWS'] = $itemRows;
$templateData['PAGINATION'] = $pagination;

$jsMessages = Loc::loadLanguageFile(__FILE__);
$jsParams = [
	'id' => $compId,
	'namespace' => 'cs_' . $randString,
	'items' => $itemRows,
	'iblock' => $iblockData,
	'pagination' => $pagination,
	'filterName' => $arParams['FILTER_NAME'],
	'ajaxUrl' => $arParams['AJAX_URL'],
];

$portlet = new Portlet();
$body = $portlet->body(function () use ($itemRows, $arResult, $blockIds) {
	?>
	<div class="catalog-section" id="<?=$blockIds['section']?>">
		<div class="catalog-showcase" id="<?=$blockIds['items']?>">
			<?php
			include __DIR__ . '/templates/items.php';
			?>
		</div>
		<div class="catalog-pagination" id="<?=$blockIds['pagination']?>">
			<?php
			include __DIR__ . '/templates/pagination.php';
			?>
		</div>
	</div>
	<?php
});
$body->addModifier('fit');
$portlet->render();
?>
<script>
(function() {
	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	new CatalogSectionShowcase(
		document.getElementById('<?=$blockIds['section']?>'),
		<?=\CUtil::PhpToJSObject($jsParams, false, false, true)?>
	);
}());
</script>
