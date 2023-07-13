<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var SaleBasketLineComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$signedParameters = \Bitrix\Main\Component\ParameterSigner::signParameters(
	$this->getComponent()->getName(),
	[
		'PATH_TO_BASKET' => $arParams['PATH_TO_BASKET']
	]
);

$jsParams = [];
$jsParams['pathToBasket'] = $arParams['PATH_TO_BASKET'];
$jsParams['pathToOrder'] = $arParams['PATH_TO_ORDER'];
$jsParams['templateName'] = $templateName;
$jsParams['signedParameters'] = $signedParameters;
$jsParams['panel'] = true;

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$currentPage = mb_strtolower($request->getRequestedPage());
$basketPage = mb_strtolower($arParams['PATH_TO_BASKET']);
if (strncmp($currentPage, $basketPage, mb_strlen($basketPage)) == 0)
{
	$jsParams['panel'] = false;
}


?>
<div id="quickbasket"></div>

<script>
(function () {
	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	var element = document.getElementById('quickbasket');
	new QuickBasket(element, <?=\CUtil::PhpToJSObject($jsParams, false, false, true)?>);
}());
</script>
<?php
