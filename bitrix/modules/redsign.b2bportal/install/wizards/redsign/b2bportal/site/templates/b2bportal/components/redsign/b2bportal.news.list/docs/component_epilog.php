<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var RSB2BPortalNewsListComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($request->isAjaxRequest())
{
	$jsonData = [
		'data' => [
			'items' => $templateData['ITEMS_ROWS'],
			'pagination' => $templateData['PAGINATION'],
			'setUrl' => $component->getRedirectUrl(),
		],
	];

	if (empty($jsonData['data']['items']))
	{
		$jsonData['data']['errors'] = [
			Loc::getMessage('RS.B2BPORTAL.TABLE.ERRORS.NO_ITEMS'),
		];
	}

	if ($APPLICATION->GetShowIncludeAreas() && count($templateData['EDIT_AREAS']))
	{
		$jsonData['data']['editAreas'] = $templateData['EDIT_AREAS'];
	}

	// $component->AbortResultCache();
	$APPLICATION->RestartBuffer();
	echo \CUtil::PhpToJSObject($jsonData);
	\CMain::FinalActions();
	die();
}


if ($APPLICATION->GetShowIncludeAreas() && count($templateData['EDIT_AREAS']))
{
	?>
	<script>
	<?php foreach ($templateData['EDIT_AREAS'] as $id => $editArea): ?>
		B2BPortal.store.commit(
			'NewsList/ADD_EDIT_AREA',
			{
				id: '<?=$id?>',
				actions: <?=\CUtil::PhpToJSObject($editArea)?>
			}
		);
	<?php endforeach; ?>
	</script>
	<?php
}
