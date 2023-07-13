<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalNewsListComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

$this->addExternalJS($templateFolder . '/js/component.js');

$pagination = [
	'perPage' => \CUtil::JSEscape($arParams['PAGE_ELEMENT_COUNT']),
	'navName' => \CUtil::JSEscape('PAGEN_' . $arResult['NAV_RESULT']->NavNum),
	'currentPage' => (int) \CUtil::JSEscape($arResult['NAV_RESULT']->NavPageNomer),
	'totalRecords' => \CUtil::JSEscape($arResult['NAV_RESULT']->NavRecordCount),
];
$templateData['PAGINATION'] = $pagination;

$sBlockId = 'docsTable' . $this->randString(5);

//////////////////////////////////////////

$portlet = new Portlet();

$body = $portlet->body(function () use ($sBlockId) {
	echo '<div id="' . $sBlockId . '_table"></div>';
});

$body->addModifier('fit');

?><div id="<?=$sBlockId?>_block"><?
$portlet->render();
?></div>

<?

//////////////////////////////////////////

$arHeader = [];

$arHeader[] = [
	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.DATE'),
	'field' => 'active_from',
	'sortable' => true,
	'html' => false,
];

$arHeader[] = [
	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.NAME'),
	'field' => 'name',
	'sortable' => true,
	'html' => false,
];

//$arHeader[] = [
//	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.TYPE'),
//	'field' => 'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_TYPE']],
//	'sortable' => true,
//	'html' => false,
//];

$arHeader[] = [
	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.TYPE'),
	'field' => 'DETAIL_PAGE_URL',
	'sortable' => true,
	'html' => true,
];

// $arHeader[] = [
//	 'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.CLIENT'),
//	 'field' => 'PROPERTY_'.$arParams['PROPERTY_CODE_ID'][$arParams['PROP_OWNER_ID']],
//	 'sortable' => true,
//	 'html' => false,
// ];

//$arHeader[] = [
//	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.ORDER'),
//	'field' => 'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_ORDER_ID']],
//	'sortable' => true,
//	'html' => false,
//];

//$arHeader[] = [
//	'label' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.DOCS.DOWNLOAD'),
//	'field' => 'actions',
//	'sortable' => false,
//	'html' => false,
//];


$templateData['EDIT_AREAS'] = [];
$arItems = [];

if (!empty($arResult['ITEMS']))
{
	foreach ($arResult['ITEMS'] as $item)
	{
		$editAreaId = $this->getEditAreaId($item['ID']);
		$ownerId = $item['PROPERTIES'][$arParams['PROP_OWNER_ID']]['VALUE'];
		$orderId = $item['PROPERTIES'][$arParams['PROP_ORDER_ID']]['VALUE'];


		$arItemRow = [
			'id' => $item['ID'],
            'DETAIL_PAGE_URL' => $item['DETAIL_PAGE_URL'],
			'editAreaId' => $editAreaId,
			'active_from' => $item['DISPLAY_ACTIVE_FROM'],
			'name' => "<a href='".$item['DETAIL_PAGE_URL']."'>".$item['NAME']."</a>",
			'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_TYPE']] => $item['DISPLAY_PROPERTIES'][$arParams['PROP_TYPE']]['DISPLAY_VALUE'],
			'property_type_badge' => 'kt-badge--' . $item['PROPERTIES'][$arParams['PROP_TYPE']]['VALUE_XML_ID'],
			'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_OWNER_ID']] => $ownerId,
			'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_OWNER_ID']] . '_url' => \CComponentEngine::makePathFromTemplate($arParams['TEMPLATE_URL_OWNER_ID'], array("ID" => urlencode($ownerId))),
			'PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_OWNER_ID']] . '_display' => $item['PROPERTIES'][$arParams['PROP_OWNER_ID']]['RS_B2B_DISPLAY_VALUE'],
			'download_link' => $item['FILE_PATH'],
		];

		if ($orderId > 0)
		{
			$arItemRow['PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_ORDER_ID']]] = $orderId;
			$arItemRow['PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_ORDER_ID']] . '_url'] = \CComponentEngine::makePathFromTemplate($arParams['TEMPLATE_URL_ORDER_ID'], array("ID" => urlencode(urlencode($item['PROPERTIES'][$arParams['PROP_ORDER_ID']]['RS_B2B_DISPLAY_VALUE']))));
			$arItemRow['PROPERTY_' . $arParams['PROPERTY_CODE_ID'][$arParams['PROP_ORDER_ID']] . '_display'] = $item['PROPERTIES'][$arParams['PROP_ORDER_ID']]['RS_B2B_DISPLAY_VALUE'];
		}

		$arItems[] = $arItemRow;

		$templateData['EDIT_AREAS'][$editAreaId] = [
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
}

$templateData['ITEMS_ROWS'] = $arItems;



?>

<script>
(function () {

	new DocsTable(
		{
			headers: <?=\Bitrix\Main\Web\Json::encode($arHeader)?>,
			items: <?=\Bitrix\Main\Web\Json::encode($arItems)?>,
			pagination: <?=\Bitrix\Main\Web\Json::encode($pagination)?>,
		},
		{
			block: '<?=$sBlockId?>_block',
			table: '<?=$sBlockId?>_table',
			siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
			pagination: {
				perPageDropdown: <?=\Bitrix\Main\Web\Json::encode($arParams['PERPAGE_DROPDOWN'])?>,
			},
			sorting: {
				initialSortBy: {
					field: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_FIELD'])?>',
					type: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_ORDER'])?>',
				}
			},
			filter: {
				filterName: '<?=CUtil::JSEscape($arParams['FILTER_NAME'])?>',
			},
			arParams: <?=\Bitrix\Main\Web\Json::encode($arParams)?>
		}
	);

}());
</script>
