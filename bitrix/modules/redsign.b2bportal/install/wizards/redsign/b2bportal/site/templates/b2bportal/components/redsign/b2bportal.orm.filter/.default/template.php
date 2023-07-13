<?php

use Bitrix\Main;
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


if (empty($arResult['FIELDS']))
	return;

$this->addExternalJS($templateFolder . '/js/component.js');

$sBlockId = 'orm-filter-' . $this->randString(5);
$collapseId = $sBlockId . '_collapse';

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($collapseId) {

	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('RS.B2BPORTAL.ORM_FILTER.HEADING'));

	$this->toolbar(function () use ($collapseId) {
		echo <<<EOL
			<a href="#{$collapseId}" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="collapse">
			<i class="fa fa-angle-down pr-0"></i>
		</a>
EOL;
	});
}));

$portlet->body(function () use ($sBlockId, $arResult, $templateFolder) {
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
		?>

		<button type="submit" name="set_filter" class="btn btn-primary"><?=Loc::getMessage('RS.B2BPORTAL.ORM_FILTER.SET_FILTER')?></button>
		<button type="button" name="reset_filter" class="btn btn-default"><?=Loc::getMessage('RS.B2BPORTAL.ORM_FILTER.RESET_FILTER')?></button>

	</form>
	<?php
})->collapsible($collapseId, Portlet\Body::COLLAPSE);

$portlet->render();

$arTagsSearch = [];
$arDateRange = [];
$arItems = [];
$arPropTagsSearchCodes = [];

if (!empty($arResult['FIELDS']))
{
	foreach ($arResult['FIELDS'] as $name => $arField)
	{
		$elementDomId = $sBlockId . '_' . $arField['CODE'] . '_prop';
		$code = $arField['CODE'] . '_prop';

		if ($arField['DISPLAY_TYPE'] == 'TAGSSEARCH')
		{
			$arItems = [];
			if (!empty($arField['DATA']['ITEMS']))
			{
				foreach ($arField['DATA']['ITEMS'] as $id => $arItem)
				{
					switch ($arField['COMPUTED_TYPE'])
					{
						case 'L':
							$arItems[] = [
								'id' => $arItem['ID'],
								'name' => $arItem['NAME'],
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
				'injectInputName' => $arField['CONTROL_NAME'] . '[]',
				'requestParams' => [
					'entity' => 'reference',
					'fieldCode' => $arField['CODE'],
					'fieldId' => $arParams['REFERENCE_' . $name . '_FIELD_ID'],
					'fieldName' => $arParams['REFERENCE_' . $name . '_FIELD_NAME'],
					'class' => $arField['CLASS'],
				],
			];
		}
		elseif ($arField['DISPLAY_TYPE'] == 'DATE_RANGE')
		{
			$class = $sBlockId . '_' . $arField['CODE'] . '_prop';

			$arDateRange[$code] = [
				'selector' => '.' . $class,
			];
		}
	}
}

?>

<script>
(function () {

	new OrmFilter(
		{
			tagssearch: <?=\Bitrix\Main\Web\Json::encode($arTagsSearch)?>,
			daterange: <?=\Bitrix\Main\Web\Json::encode($arDateRange)?>,
		},
		{
			el: {
				$form: document.getElementById('<?=$sBlockId?>_form'),
			},
			filterName: '<?=CUtil::JSEscape($arParams['FILTER_NAME'])?>',
			componentName: '<?=CUtil::JSEscape('redsign:b2bportal.orm.filter')?>',
		}
	);

}());
</script>
