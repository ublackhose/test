<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalCatalogSectionComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');

$jsParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('RS.B2BPORTAL.TABLE.COLS.MESS_NOT_AVAILABLE');
$jsParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('RS.B2BPORTAL.TABLE.COLS.MESS_BTN_ADD_TO_BASKET');
$jsParams['MESS_ACTION_MENU'] = $arParams['MESS_ACTION_MENU'] ?: Loc::getMessage('RS.B2BPORTAL.TABLE.COLS.MESS_ACTION_MENU');

$jsParams['RELATIVE_QUANTITY_FACTOR'] = $arParams['RELATIVE_QUANTITY_FACTOR'];

$jsParams['MESS_RELATIVE_QUANTITY_MANY'] = empty($arParams['MESS_RELATIVE_QUANTITY_MANY']) ?
	Loc::getMessage('RS_B2B_CS_RELATIVE_QUANTITY_MANY') : $arParams['MESS_RELATIVE_QUANTITY_MANY'];

$jsParams['MESS_RELATIVE_QUANTITY_FEW'] = empty($arParams['MESS_RELATIVE_QUANTITY_FEW']) ?
	Loc::getMessage('RS_B2B_CS_RELATIVE_QUANTITY_FEW') : $arParams['MESS_RELATIVE_QUANTITY_FEW'];

$jsParams['MESS_RELATIVE_QUANTITY_NO'] = empty($arParams['MESS_RELATIVE_QUANTITY_NO']) ?
	Loc::getMessage('RS_B2B_CS_RELATIVE_QUANTITY_NO') : $arParams['MESS_RELATIVE_QUANTITY_NO'];

$jsParams['BASKET'] = [
	'BASKET_URL' => $arParams['BASKET_URL'],
	'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
];

$jsParams['PRODUCT_QUANTITY_VARIABLE'] = $arParams['PRODUCT_QUANTITY_VARIABLE'];
$jsParams['QUANTITY_DISPLAY_MODE'] = $arParams['SHOW_MAX_QUANTITY'] === 'M' ? 2 : 1;
$jsParams['USE_STORE'] = $arParams['USE_STORE'] === 'Y';
$jsParams['STORES'] = $arParams['STORES'];
$jsParams['MAX_QUANTITY'] = (int) $arParams['MAX_QUANTITY'];

$jsParams['CATALOG_SORTER'] = $arParams['CATALOG_SORTER'];
$jsParams['AJAX_URL'] = $arParams['AJAX_URL'];
$jsParams['BLOCK_TITLE'] = $arParams['BLOCK_TITLE'] ?? '';
$jsParams['RS_VIEW_MODE'] = $arParams['RS_VIEW_MODE'];
$jsParams['ENABLE_PREVIEW_PICTURE'] = $arParams['ENABLE_PREVIEW_PICTURE'] === 'Y';
$jsParams['STORAGE_PREFIX'] = $arParams['STORAGE_PREFIX'];

$templateData['EDIT_AREAS'] = [];
foreach ($arResult['ITEMS'] as $item)
{
	$templateData['EDIT_AREAS'][$this->getEditAreaId($item['ID'])] = [
		'edit' => [
			'link' => $item['EDIT_LINK'],
			'text' => \CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_EDIT')
		],
		'delete' => [
			'link' => $item['DELETE_LINK'],
			'text' => \CIBlock::GetArrayByID($item['IBLOCK_ID'], 'ELEMENT_DELETE')
		]
	];
}
unset($item);



/** @var RSB2BPortalCatalogSectionComponent */
$component = $this->getComponent();

/** @var array */
$headers = $component->getHeaders();

/** @var array */
$itemsRows = $templateData['ITEMS_ROWS'] = $component->getItemsRows();

/** @var array */
$skuProps = $templateData['SKU_PROPS'] = $component->getSkuProps();

$prices = array_values(array_map(function ($group) {
	return [
		'id' => $group['ID'],
		'code' => $group['CODE'],
		'canBuy' => $group['CAN_BUY'],
		'title' => $group['TITLE']
	];
}, $arResult['PRICES']));

$pagination = [
	'hide' => \CUtil::JSEscape($arParams['HIDE_FOOT'] == 'Y' ? 'Y' : 'N'),
	'perPage' => (int) \CUtil::JSEscape($arParams['PAGE_ELEMENT_COUNT']),
	'navName' => \CUtil::JSEscape('PAGEN_' . $arResult['NAV_RESULT']->NavNum),
	'currentPage' => (int) \CUtil::JSEscape($arResult['NAV_RESULT']->NavPageNomer),
	'totalRecords' => \CUtil::JSEscape($arResult['NAV_RESULT']->NavRecordCount),
];
$templateData['PAGINATION'] = $pagination;

$sBlockId = $templateData['BLOCK_ID'] = 'catalog_section_' . $this->randString(5);

$useToolbar = $arParams['HIDE_HEAD'] !== 'Y';
$toolbarOptions = [
	'previewSwitcher' => $arParams['PREVIEW_PICTURE_SWITCHER'] === 'Y',
	'export' => $arParams['USE_EXPORT'] === true || $arParams['USE_EXPORT'] === 'Y',
	'exportTypes' => $arParams['EXPORT_TYPES'],
	'exportActionVariable' => $arParams['EXPORT_ACTION_VARIABLE'],
];

$portlet = new Portlet();
if ($arParams['HIDE_HEAD'] !== 'Y' || $arParams['PREVIEW_PICTURE_SWITCHER'] !== 'N') {
	/** @var Portlet\Head $head */
	$head = $portlet->head(new Portlet\Head(function () use ($arParams) {

		/** @var Portlet\Head $this */
		$this->title(function () use ($arParams) {

			if (!empty($arParams['BLOCK_TITLE']))
			{
				echo $arParams['BLOCK_TITLE'];
			}
		});
	}));

	$head->sticky(true);
}

/** @var Portlet\Body */
$body = $portlet->body(function () use ($sBlockId) {
	echo '<div id="' . $sBlockId . '_table"></div>';
});

$body->addModifier('fit');

?><div id="<?=$sBlockId?>_block"><?php $portlet->render(); ?></div>

<script>
(function () {

	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	window.catalog_<?=$sBlockId?> = new B2BPortal.Components.CatalogSection(
		{
			headers: <?=\Bitrix\Main\Web\Json::encode($headers)?>,
			items: <?=\CUtil::PhpToJSObject($itemsRows, false, false, true)?>,
			prices: <?=\CUtil::PhpToJSObject($prices)?>,
			pagination: <?=\Bitrix\Main\Web\Json::encode($pagination)?>,
		},
		{
			id: '<?=$sBlockId?>',
			block: '<?=$sBlockId?>_block',
			table: '<?=$sBlockId?>_table',

			siteId: '<?=\CUtil::JSEscape($component->getSiteId())?>',
			pagination: {
				perPageDropdown: <?=\Bitrix\Main\Web\Json::encode($arParams['CATALOG_SORTER']['PERPAGE_DROPDOWN'])?>,
			},
			sorting: {
				initialSortBy: {
					field: '<?=\CUtil::JSEscape($arParams['ELEMENT_SORT_FIELD'])?>',
					type: '<?=\CUtil::JSEscape($arParams['ELEMENT_SORT_ORDER'])?>',
				}
			},
			filter: {
				filterName: '<?=\CUtil::JSEscape($arParams['FILTER_NAME'])?>',
			},

			skuProps: <?=\CUtil::PhpToJSObject($skuProps, false, false, true)?>,

			useToolbar: <?=$useToolbar ? 'true' : 'false' ?>,
			toolbar: <?=\CUtil::PhpToJSObject($toolbarOptions)?>,

			imagesPath: {
				noPropValue: '<?=$templateFolder?>/images/no_prop_value.png',
				noimage: '<?=$templateFolder?>/images/noimage.png',
			},
			arParams: <?=\Bitrix\Main\Web\Json::encode($jsParams)?>
		}
	);
}());
</script>