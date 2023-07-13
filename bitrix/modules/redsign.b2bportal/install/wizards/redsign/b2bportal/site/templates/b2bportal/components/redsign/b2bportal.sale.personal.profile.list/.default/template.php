<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalPersonalProfileList $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');

$pagination = $arResult['NAV_RESULT'];
$pagination['navPageValuePrefix'] = 'page-';
$templateData['PAGINATION'] = $pagination;

$sBlockId = 'profileListTable' . $this->randString(5);

//////////////////////////////////////////

$portlet = new Portlet();

if ($arParams['URL_TO_ADD'])
{
	$portlet->head(new Portlet\Head(function () use ($arParams) {


		/** @var Portlet\Head $this */
		$this->toolbar(function () use ($arParams) {

			$btnText = Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_BUTTON_ADD');

			echo <<<EOL
				<a class="btn btn-default btn-bold btn-upper btn-font-sm" href="{$arParams['URL_TO_ADD']}">
					<i class="flaticon2-add-1"></i>
					{$btnText}
				</a>
EOL;
		});
	}));
}

$body = $portlet->body(function () use ($sBlockId) {
	echo '<div id="' . $sBlockId . '_table"></div>';
});

$body->addModifier('fit');

?><div id="<?=$sBlockId?>_block"><?
$portlet->render();
?></div><?

//////////////////////////////////////////

$arHeader = [];

$arHeader[] = [
	'label' => Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_LIST_ID'),
	'field' => 'ID',
	'sortable' => false,
	'html' => false,
];

$arHeader[] = [
	'label' => Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_LIST_NAME'),
	'field' => 'NAME',
	'sortable' => true,
	'html' => false,
];

$arHeader[] = [
	'label' => Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_LIST_DATE_UPDATE'),
	'field' => 'DATE_UPDATE',
	'sortable' => true,
	'html' => false,
];

$arHeader[] = [
	'label' => Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_LIST_SALE_TYPE'),
	'field' => 'SALE_TYPE',
	'sortable' => true,
	'html' => false,
];

if (!empty($arResult['HEADERS']))
{
	foreach ($arResult['HEADERS'] as $arPropHeader)
	{
		$sort = (in_array($arPropHeader['CODE'], $arParams['SORT_FIELDS']) ? true : false);
		$arHeader[] = [
			'label' => $arPropHeader['NAME'],
			'field' => $arPropHeader['CODE'],
			'sortable' => $sort,
			'html' => false,
		];
	}
}

$arHeader[] = [
	'label' => Loc::getMessage('RS_B2BPORTAL_SPPL_NEWS_LIST_PROFILE_LIST_ACTIONS'),
	'field' => 'actions',
	'sortable' => false,
	'html' => false,
];


$arItems = [];

if (!empty($arResult['PROFILES']))
{
	foreach ($arResult['PROFILES'] as $item)
	{
		$editAreaId = $this->getEditAreaId($item['ID']);
		$ownerId = (float) $item['PROPERTIES'][$arParams['PROP_OWNER_ID']]['VALUE'];
		$orderId = (float) $item['PROPERTIES'][$arParams['PROP_ORDER_ID']]['VALUE'];

		$arItemRow = [
			'ID' => $item['ID'],
			'NAME' => $item['NAME'],
			'DATE_UPDATE' => $item['DATE_UPDATE'],
			'SALE_TYPE' => $item['PERSON_TYPE']['NAME'],
			'detail_page_url' => $item['URL_TO_DETAIL'],
			'delete_page_url' => $item['URL_TO_DETELE'],
			'copy_page_url' => $item['URL_TO_COPY'],
		];

		if (!empty($arResult['HEADERS']))
		{
			foreach ($arResult['HEADERS'] as $arProp)
			{
				$arItemRow[$arProp['CODE']] = (!empty($item['PROPS'][$arProp['CODE']]) ? $item['PROPS'][$arProp['CODE']] : '');
			}
		}

		$arItems[] = $arItemRow;
	}
}

$templateData['ITEMS_ROWS'] = $arItems;

?>

<script>
(function () {

	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	new SalePersonalProfileListTable(
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
				perPageDropdown: <?=\Bitrix\Main\Web\Json::encode($arParams['CATALOG_SORTER']['PERPAGE_DROPDOWN'])?>,
			},
			sorting: {
				initialSortBy: {
					field: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_FIELD'])?>',
					type: '<?=CUtil::JSEscape($arParams['ELEMENT_SORT_ORDER'])?>',
				}
			},
			arParams: <?=\Bitrix\Main\Web\Json::encode($arParams)?>
		}
	);

}());
</script>
