<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
if ($_REQUEST['update'] == "Y") {



} else
{

$isCollapsed = in_array('user_info', $arResult['COLLAPSED_BLOCKS']);
$renderBlock('user_info', Loc::getMessage('SPOD_ORDER_USER_INFO'), $isCollapsed, function () use ($arResult, $arParams) {
	if (strlen($arResult["USER"]["LOGIN"]) && !in_array("LOGIN", $arParams['HIDE_USER_INFO']))
	{
		?>
		<div class="mb-4">
			<h6><?= Loc::getMessage('SPOD_LOGIN')?>:</h6>
			<p class="mb-0"><?= htmlspecialcharsbx($arResult["USER"]["LOGIN"]) ?></p>
		</div>
		<?
	}
	if (strlen($arResult["USER"]["EMAIL"]) && !in_array("EMAIL", $arParams['HIDE_USER_INFO']))
	{
		?>
		<div class="mb-4">
			<h6><?= Loc::getMessage('SPOD_EMAIL')?>:</h6>
			<p class="mb-0"><a class="" href="mailto:<?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?>"><?= htmlspecialcharsbx($arResult["USER"]["EMAIL"]) ?></a></p>
		</div>
		<?
	}
	if (strlen($arResult["USER"]["PERSON_TYPE_NAME"]) && !in_array("PERSON_TYPE_NAME", $arParams['HIDE_USER_INFO']))
	{
		?>
		<div class="mb-4">
			<h6><?= Loc::getMessage('SPOD_PERSON_TYPE_NAME') ?>:</h6>
			<p class="mb-0"><?=htmlspecialcharsbx($arResult["USER"]["PERSON_TYPE_NAME"]) ?></p>
		</div>
		<?
	}
});
}
