<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arParams['FIELD_CODE']))
	return;

$this->addExternalJS($templateFolder . '/js/component.js');

$sBlockId = 'organizationTable' . $this->randString(5);

//////////////////////////////////////////

$portlet = new Portlet();

$body = $portlet->body(function () use ($sBlockId) {
	echo '<div id="' . $sBlockId . '_table"></div>';
});

$body->addModifier('fit');

?><div id="<?=$sBlockId?>_block"><?
$portlet->render();
?></div><?

//////////////////////////////////////////

$arHeader = [];

$arKeys = array_keys(reset($arResult['ITEMS']));
foreach ($arKeys as $code)
{
	$arHeader[] = [
		'label' => $code,
		'field' => $code,
		'sortable' => true,
		'html' => false,
	];
}

$arItems = [];

if (!empty($arResult['ITEMS']))
{
	$i = 0;
	foreach ($arResult['ITEMS'] as $item)
	{
		$arItemRow = [];

		foreach ($arKeys as $code)
		{
			$arItemRow[$code] = $item[$code];
		}

		$arItems[] = $arItemRow;
	}
}

?>

<script>
(function () {

	new OrmList(
		{
			headers: <?=\Bitrix\Main\Web\Json::encode($arHeader)?>,
			items: <?=\Bitrix\Main\Web\Json::encode($arItems)?>,
			pagination: {
				perPage: <?=CUtil::JSEscape($arParams['ROWS_PER_PAGE'])?>,
				navName: '<?=CUtil::JSEscape($arResult['NAV_RESULT']->NavId)?>',
				navPageValuePrefix: 'page-',
				currentPage: <?=CUtil::JSEscape($arResult['NAV_RESULT']->NavCurrentPage)?>,
				totalRecords: <?=CUtil::JSEscape($arResult['NAV_RESULT']->NavRecordCount)?>,
			},
		},
		{
			block: '<?=$sBlockId?>_block',
			table: '<?=$sBlockId?>_table',
			multipleAction: '<?=$sBlockId?>_multiple_action',
			siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
			pagination: {
				perPageDropdown: <?=\Bitrix\Main\Web\Json::encode($arParams['CATALOG_WRAP']['PERPAGE_DROPDOWN'])?>,
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

<?php
if ($arParams['AJAX_REQUEST'] == 'Y')
{
	$APPLICATION->RestartBuffer();

	$jsonData = [
		'data' => [
			'items' => $arItems,
			'pagination' => [
				'perPage' => $arParams['ROWS_PER_PAGE'],
				'navName' => $arResult['NAV_RESULT']->NavId,
				'navPageValuePrefix' => 'page-',
				'currentPage' => $arResult['NAV_RESULT']->NavCurrentPage,
				'totalRecords' => $arResult['NAV_RESULT']->NavRecordCount,
			],
			'setUrl' => $arParams['SET_URL'],
		],
	];

	if (empty($arItems))
	{
		$jsonData['data']['errors'] = [
			Loc::getMessage('RS.B2BPORTAL.ORM_LIST.ERRORS.NO_ITEMS')
		];
	}

	echo \Bitrix\Main\Web\Json::encode($jsonData);

	die();
}
