<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalPersonalProfileDetail $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$sBlockId = 'profileDetail' . $this->randString(5);

//////////////////////////////////////////

$portlet = new Portlet();

if (!empty($arParams['PATH_TO_LIST']))
{
	$portlet->head(new Portlet\Head(function () use ($arParams) {

		/** @var Portlet\Head $this */
		$this->title(function () use ($arParams) {
			?><a class="btn btn-default btn-bold btn-upper btn-font-sm" href="<?=$arParams['PATH_TO_LIST']?>"><i class="la la-angle-left"></i><?=Loc::getMessage('SPPD_RECORDS_LIST')?></a><?
		});
	}));
}

$body = $portlet->body(function () use ($arResult, $arParams, $component) {

	if (strlen($arResult['ID']) > 0)
	{
		global $APPLICATION;

		ShowError($arResult["ERROR_MESSAGE"]);
		?>
		<form class="kt-form" method="post" class="sale-profile-detail-form" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">

			<?=bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

			<div class="form-group row">
				<label class="col-12 col-md-4 text-right"><?=Loc::getMessage('SALE_PERS_TYPE')?></label>
				<div class="col-12 col-md-8">
					<div class="form-control-static"><?=$arResult["PERSON_TYPE"]["NAME"]?></div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-12 col-md-4 text-right" for="sale-personal-profile-detail-name">
					<?=Loc::getMessage('SALE_PNAME')?>:<span class="sale-personal-profile-req">*</span>
				</label>
				<div class="col-12 col-md-8 text-right">
					<input class="form-control" type="text" name="NAME" maxlength="50" id="sale-personal-profile-detail-name" value="<?=$arResult["NAME"]?>" />
				</div>
			</div>

			<?php
			foreach ($arResult["ORDER_PROPS"] as $block)
			{
				if (!empty($block["PROPS"]))
				{
					?>

					<div class="form-group row form-group-last mt-5">
						<div class="col-12 col-md-4"></div>
						<div class="col-12 col-md-8">
							<h5><?= $block["NAME"]?></h5>
						</div>
					</div>

					<?
					foreach ($block["PROPS"] as $property)
					{
						$APPLICATION->IncludeComponent(
							'redsign:b2bportal.sale.personal.profile.property.item',
							'',
							array(
								'RESULT' => [
									'PROPERTY' => $property,
									'ORDER_PROPS_VALUES' => $arResult['ORDER_PROPS_VALUES'],
								],
								'PARAMS' => $arParams,
							),
							$component,
							['HIDE_ICONS' => 'Y']
						);
					}
				}
			}
			?>
			<div class="form-group row form-group-last">
				<div class="col-12 col-md-4"></div>
				<div class="col-12 col-md-8">
					<input type="submit" class="btn btn-primary" name="save" value="<?=GetMessage("SALE_SAVE") ?>">
					&nbsp;
					<input type="submit" class="btn btn-default" name="apply" value="<?=GetMessage("SALE_APPLY")?>">
					&nbsp;
					<input type="submit" class="btn btn-default" name="reset" value="<?=GetMessage("SALE_RESET")?>">
				</div>
			</div>
		</form>
		<div class="clearfix"></div>
		<?php
	}
	else
	{
		ShowError($arResult['ERROR_MESSAGE']);
	}
});

?><div id="<?=$sBlockId?>_block"><?
$portlet->render();
?></div><?

//////////////////////////////////////////

$APPLICATION->SetTitle($arResult['NAME']);
