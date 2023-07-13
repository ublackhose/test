<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var \Redsign\Component\B2BPortal\BalanceList $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if ($arResult['ERRORS'])
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm(Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_NEED_AUTH'), false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
else
{
	$this->addExternalJS($templateFolder . '/js/component.js');

	$pagination = $arResult['NAV_RESULT'];
	$pagination['navPageValuePrefix'] = 'page-';
	$templateData['PAGINATION'] = $pagination;

	$sBlockId = 'balanceListTable' . $this->randString(5);

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

	$arHeader[] = [
		'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_ID'),
		'field' => 'ID',
		'sortable' => false,
		'html' => false,
	];

	// $arHeader[] = [
	// 	'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_PROFILE_NAME'),
	// 	'field' => 'PROFILE_NAME',
	// 	'sortable' => true,
	// 	'html' => false,
	// ];

	$arHeader[] = [
		'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_COMPANY_NAME'),
		'field' => 'COMPANY_NAME',
		'sortable' => true,
		'html' => false,
	];

	$arHeader[] = [
		'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_TAXPAYER_CODE'),
		'field' => 'TAXPAYER_CODE',
		'sortable' => true,
		'html' => false,
	];

	$arHeader[] = [
		'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_BALANCE'),
		'field' => 'VALUE',
		'sortable' => true,
		'html' => false,
	];

	$arHeader[] = [
		'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_DATE_UPDATE'),
		'field' => 'DATE_UPDATE',
		'sortable' => true,
		'html' => false,
	];

	// $arHeader[] = [
	// 	'label' => Loc::getMessage('RS_B2BPORTAL_SBL_TPL_DEFAULT_ACTIONS'),
	// 	'field' => 'actions',
	// 	'sortable' => false,
	// 	'html' => false,
	// ];


	$arItems = [];

	if (!empty($arResult['ITEMS']))
	{
		foreach ($arResult['ITEMS'] as $item)
		{
			$arItemRow = [
				'ID' => $item['ID'],
				'COMPANY_NAME' => $item['COMPANY_NAME'],
				'TAXPAYER_CODE' => $item['TAXPAYER_CODE'],
				'DATE_UPDATE' => $item['DATE_UPDATE'] ? $item['DATE_UPDATE']->format('d.m.Y H:i:s') : '',
				'VALUE' => $item['VALUE_FORMAT'] ? $item['VALUE_FORMAT'] : $item['VALUE'],
				// 'actions' => '',
			];

			$arItems[] = $arItemRow;
		}
	}

	$templateData['ITEMS_ROWS'] = $arItems;

	$arParams['ELEMENT_SORT_FIELD'] = 'ID';
	$arParams['ELEMENT_SORT_ORDER'] = 'ASC';
	?>

	<script>
	(function () {

		<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
		BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

		new BalanceListTable(
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
	<?php
}
