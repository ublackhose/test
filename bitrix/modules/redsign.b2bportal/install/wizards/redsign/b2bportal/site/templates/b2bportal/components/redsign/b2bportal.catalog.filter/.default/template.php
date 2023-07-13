<?php

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var B2bPortalCatalogFilterComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arResult['FIELDS']) && empty($arResult['PROPERTIES']) && empty($arResult['PRICES']))
	return;

Loc::loadMessages(__FILE__);

$this->addExternalJS($templateFolder . '/js/component.js');

$sBlockId = 'filter-' . $this->randString(5);
$collapseId = $sBlockId . '_collapse';

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($arParams, $collapseId) {

	/** @var Portlet\Head $this */
	$this->title($arParams['BLOCK_TITLE'] ?: Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.HEADING'));

	$this->toolbar(function () use ($collapseId) {
		echo <<<EOL
			<a href="#{$collapseId}" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="collapse">
				<i class="fa fa-angle-down pr-0"></i>
			</a>
EOL;
	});
}));

$portlet->body(function () use ($sBlockId, $arResult, $arParams, $templateFolder) {
	$documentRoot = Main\Application::getDocumentRoot();
	?>
<form action="<?=$arResult['FORM_ACTION']?>" method="get" id="<?=$sBlockId?>_form">

	<?php
	$templatePath = $documentRoot . $templateFolder . '/include/fields.php';
	$file = new Main\IO\File($templatePath);
	if ($file->isExists())
	{
		include($file->getPath());
	}

	$templatePath = $documentRoot . $templateFolder . '/include/properties.php';
	$file = new Main\IO\File($templatePath);
	if ($file->isExists())
	{
		include($file->getPath());
	}

	$templatePath = $documentRoot . $templateFolder . '/include/prices.php';
	$file = new Main\IO\File($templatePath);
	if ($file->isExists())
	{
		include($file->getPath());
	}
	?>

	<button type="submit" name="set_filter" class="btn btn-primary"><?=Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.SET_FILTER')?></button>
	<button type="button" name="reset_filter" class="btn btn-default"><?=Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.RESET_FILTER')?></button>

</form>

	<?php
})->collapsible($collapseId, Portlet\Body::COLLAPSE);

$portlet->render();

$arTagsSearch = [];
$arDateRange = [];
$arItems = [];
$arPropTagsSearchCodes = [];

if (!empty($arResult['FIELDS']['SUBSECTIONS']))
{
	if (!empty($arResult['FIELDS']['SUBSECTIONS']['DATA']['ITEMS']))
	{
		foreach ($arResult['FIELDS']['SUBSECTIONS']['DATA']['ITEMS'] as $arSection)
		{
			$arItems[] = [
				'id' => $arSection['ID'],
				'name' => $arSection['NAME'],
			];
		}
	}

	$elementDomId = $sBlockId . '_subsections';
	$code = 'subsections';

	$arTagsSearch[$code] = [
		'code' => $code,
		'elementDomId' => $elementDomId,
		'items' => $arItems,
		'searchItems' => [],
		'isSearchResultLock' => false,
		'injectInputName' => $arResult['FIELDS']['SUBSECTIONS']['CONTROL_NAME'] . '[]',
		'messages' => [
			'notFound' => Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.TAGSSEARCH.NOT_FOUND'),
			'placeholder' => Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.TAGSSEARCH.PLACEHOLDER'),
		],
		'requestParams' => [
			'entity' => 'subsections',
			'iblockId' => $arParams['IBLOCK_ID'],
			'sectionId' => (!empty($arParams['SECTION_ID']) ? $arParams['SECTION_ID'] : 0),
		],
		'placeholder' => Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.TAGSSEARCH.PLACEHOLDER'),
	];
}

if (!empty($arResult['FIELDS']['ACTIVE_FROM']))
{
	$code = 'active_from';
	$class = $sBlockId . '_ACTIVE_FROM';

	$arDateRange[$code] = [
		'selector' => '.' . $class,
	];
}

if (!empty($arResult['FIELDS']['ACTIVE_TO']))
{
	$code = 'active_to';
	$class = $sBlockId . '_ACTIVE_TO';

	$arDateRange[$code] = [
		'selector' => '.' . $class,
	];
}

if (!empty($arResult['PROPERTIES']))
{
	foreach ($arResult['PROPERTIES'] as $propertyId => $arProperty)
	{
		$elementDomId = $sBlockId . '_' . $arProperty['CODE'] . '_prop';
		$code = $arProperty['CODE'] . '_prop';
		if ($arProperty['DISPLAY_TYPE'] == 'TAGSSEARCH')
		{
			$arItems = [];
			if (!empty($arProperty['DATA']['ITEMS']))
			{
				foreach ($arProperty['DATA']['ITEMS'] as $id => $arItem)
				{
					switch ($arProperty['COMPUTED_TYPE'])
					{
						case 'L':
							$arItems[] = [
								'id' => $arItem['ID'],
								'name' => $arItem['VALUE'],
							];
							break;
						case 'S:directory':
							$arItems[] = [
								'id' => $arItem['UF_XML_ID'],
								'name' => $arItem['UF_NAME'],
							];
							break;
					}
				}
			}

			$arTagsSearch[$code] = [
				'code' => $code,
				'elementDomId' => $elementDomId,
				'items' => $arItems,
				'searchItems' => [],
				'isSearchResultLock' => false,
				'injectInputName' => $arProperty['CONTROL_NAME'] . '[]',
				'messages' => [
					'notFound' => Loc::getMessage('RS.B2BPORTAL.CATALOG_FILTER.TAGSSEARCH.NOT_FOUND'),
					'placeholder' => $arParams['PROPERTY_' . $arProperty['CODE'] . '_PLACEHOLDER'] ?? '',
				],
				'requestParams' => [
					'entity' => 'property',
					'iblockId' => $arParams['IBLOCK_ID'],
					'propertyId' => $arProperty['ID'],
				],
			];
		}
		elseif ($arProperty['DISPLAY_TYPE'] == 'DATE_RANGE')
		{
			$class = $sBlockId . '_' . $arProperty['CODE'] . '_prop';

			$arDateRange[$code] = [
				'selector' => '.' . $class,
			];
		}
	}
}
?>

<script>
(function () {

	new CatalogFilter(
		{
			tagssearch: <?=\Bitrix\Main\Web\Json::encode($arTagsSearch)?>,
			daterange: <?=\Bitrix\Main\Web\Json::encode($arDateRange)?>,
		},
		{
			el: {
				$form: document.getElementById('<?=$sBlockId?>_form'),
			},
			filterName: '<?=CUtil::JSEscape($arParams['FILTER_NAME'])?>',
			componentName: '<?=CUtil::JSEscape('redsign:b2bportal.catalog.filter')?>',
		}
	);

}());
</script>
