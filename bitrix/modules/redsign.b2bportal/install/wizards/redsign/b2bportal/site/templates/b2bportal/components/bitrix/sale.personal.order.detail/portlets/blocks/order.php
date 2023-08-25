<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($component, $arResult, $arParams) {

	/** @var Portlet\Head $this */
	$this->title(function () use ($component, $arResult, $arParams) {
		echo Loc::getMessage('SPOD_SUB_ORDER_TITLE', [
			"#ACCOUNT_NUMBER#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"]),
			"#DATE_ORDER_CREATE#" => $arResult["DATE_INSERT_FORMATED"]
		]);

		include 'status.php';
	});

	$this->toolbar(function () use ($arParams, $arResult) {
		if ($arParams['GUEST_MODE'] !== 'Y')
		{
			if ($arResult["CAN_CANCEL"] === "Y")
			{
				?>
				<a href="<?=$arResult["URL_TO_CANCEL"]?>" class="btn btn-outline-danger mr-1">
					<?= Loc::getMessage('SPOD_ORDER_CANCEL') ?>
				</a>
				<?php
			}
			?>
			<a href="<?=$arResult["URL_TO_COPY"]?>" class="btn btn-outline-primary">
				<?= Loc::getMessage('SPOD_ORDER_REPEAT') ?>123
			</a>
			<?php
		}
	});
}));

$portlet->body(function () use ($arResult) {
	?>
	<div class="row">

		<div class="col-12 col-md-6 col-lg-6 col-xl-3">
			<?php $userName = $arResult["USER_NAME"]; ?>
			<h6><?php
			if (strlen($userName) || strlen($arResult['FIO']))
			{
				echo Loc::getMessage('SPOD_LIST_FIO') . ':';
			}
			else
			{
				echo Loc::getMessage('SPOD_LOGIN') . ':';
			}
			?></h6>
			<p class="mb-0"><?php
			if (strlen($userName))
			{
				echo htmlspecialcharsbx($userName);
			}
			elseif (strlen($arResult['FIO']))
			{
				echo htmlspecialcharsbx($arResult['FIO']);
			}
			else
			{
				echo htmlspecialcharsbx($arResult["USER"]['LOGIN']);
			}
			?></p>
		</div>


		<div class="col-12 col-md-6 col-lg-6 col-xl-3">
			<h6><?=Loc::getMessage('SPOD_LIST_CURRENT_STATUS_DATE', [
				'#DATE_STATUS#' => $arResult["DATE_STATUS_FORMATED"]
			])?></h6>
			<p class="mb-0">
				<?php include 'status.php'; ?>
			</p>
		</div>

		<div class="col-12 col-md-6 col-lg-6 col-xl-3">
			<h6><?=Loc::getMessage('SPOD_ORDER_CANCELED')?></h6>
			<p class="mb-0"><?=$arResult['CANCELED'] === 'Y' ? Loc::getMessage('SPOD_YES') : Loc::getMessage('SPOD_NO')?></p>
		</div>

		<div class="col-12 col-md-6 col-lg-6 col-xl-3">
			<h6><?=Loc::getMessage('SPOD_ORDER_PRICE')?></h6>
			<p class="mb-0"><?=$arResult["PRICE_FORMATED"]?></p>
		</div>
	</div>
	<?
});

$portlet->render();

unset($portlet);
