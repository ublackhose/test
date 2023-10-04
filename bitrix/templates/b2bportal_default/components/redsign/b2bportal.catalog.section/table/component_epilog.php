<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var RSB2BPortalCatalogSectionComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest() && $templateData['BLOCK_ID'] === $request->getPost('comp_id')) // ajax requests
{
	$jsonData = [
		'data' => [
			'items' => $templateData['ITEMS_ROWS'],
			'pagination' => $templateData['PAGINATION'],
			'skuProps' => $templateData['SKU_PROPS'],
			'setUrl' => $component->getRedirectUrl(),
		],
	];

	if (empty($jsonData['data']['items']))
	{
		$jsonData['data']['errors'] = [
			Loc::getMessage('RS.B2BPORTAL.TABLE.ERRORS.NO_ITEMS')
		];
	}

	if ($APPLICATION->GetShowIncludeAreas() && count($templateData['EDIT_AREAS']))
	{
		$jsonData['data']['editAreas'] = $templateData['EDIT_AREAS'];
	}

	// $component->AbortResultCache();
	$APPLICATION->RestartBuffer();
	echo \CUtil::PhpToJSObject($jsonData, false, false, true);
	\CMain::FinalActions();
	die();
}


if ($APPLICATION->GetShowIncludeAreas() && count($templateData['EDIT_AREAS']))
{
	?>
	<script>
	  window.catalog_<?=$templateData['BLOCK_ID']?>.setEditAreas(<?=\CUtil::PhpToJSObject($templateData['EDIT_AREAS'])?>);
	</script>
	<?php
}