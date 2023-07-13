<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalPersonalProfileAdd $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arResult['PERSON_TYPE']))
	return;

$this->addExternalJS($templateFolder . '/js/component.js');

$comp = $this;

$sBlockId = 'profileAdd' . $this->randString(5);

//////////////////////////////////////////

$portlet = new Portlet();

if (!empty($arParams['PATH_TO_LIST']))
{
	$portlet->head(new Portlet\Head(function () use ($arParams) {

		/** @var Portlet\Head $this */
		$this->title(function () use ($arParams) {
			?><a class="btn btn-default btn-bold btn-upper btn-font-sm" href="<?=$arParams['PATH_TO_LIST']?>"><i class="la la-angle-left"></i><?=Loc::getMessage('RS_B2BPORTAL_SPPA_TO_LIST')?></a><?
		});
	}));
}

$body = $portlet->body(function () use ($arResult, $arParams, $sBlockId, $comp) {

	global $APPLICATION;

	if (!empty($arResult['ERROR_MESSAGE']))
	{
		?>
		<div class="alert alert-danger" role="alert">
			<div class="alert-text">
				<?php
				if (is_array($arResult['ERROR_MESSAGE']))
				{
					echo implode('<br>', $arResult['ERROR_MESSAGE']);
				}
				else
				{
					echo $arResult['ERROR_MESSAGE'];
				}
				?>
			</div>
		</div>
		<?php
	}
	?>

	<form class="kt-form" method="post" class="sale-profile-detail-form" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">

		<?=bitrix_sessid_post()?>
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">

		<div id="<?=$sBlockId?>_person_type"></div>

		<div class="form-group row">
			<label class="col-12 col-md-4 text-right" for="sale-personal-profile-detail-name">
				<?=Loc::getMessage('SALE_PNAME')?>:<span class="sale-personal-profile-req">*</span>
			</label>
			<div class="col-12 col-md-8 text-right">
				<input class="form-control" type="text" name="NAME" id="sale-personal-profile-detail-name" value="<?=$arResult['NAME']?>" />
			</div>
		</div>

		<?php
		if (!empty($arResult['GROUP'])):
			foreach ($arResult['GROUP'] as $arGroup):
				if (!$arGroup['HAVE_PROPS'])
					continue;
				?>
				<div class="form-group row form-group-last mt-5">
					<div class="col-12 col-md-4"></div>
					<div class="col-12 col-md-8">
						<h5><?=$arGroup['NAME']?></h5>
					</div>
				</div>
				<?php
				if (!empty($arResult['PROPERTY'])):
					foreach ($arResult['PROPERTY'] as $property):
						if (
							$property['PERSON_TYPE_ID'] != $arResult['PERSON_TYPE_ID_CHECKED']
							|| $arGroup['ID'] != $property['PROPS_GROUP_ID']
						)
							continue;

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
							$comp->__component,
							['HIDE_ICONS' => 'Y']
						);
					endforeach;
				endif;
			endforeach;
		endif;
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
});

?><div id="<?=$sBlockId?>_form"><?
$portlet->render();
?></div><?

//////////////////////////////////////////

$personTypeItems = [];
foreach ($arResult['PERSON_TYPE'] as $arPersonType)
{
	$personTypeItems[] = [
		'id' => $arPersonType['ID'],
		'name' => $arPersonType['NAME'],
		'code' => $arPersonType['CODE'],
		'checked' => ($arPersonType['CHECKED'] == 'Y' ? true : false),
	];
}
$personType = [
	'element' => $sBlockId . '_person_type',
	'items' => $personTypeItems,
];

$form = [
	'element' => $sBlockId . '_form',
	'form_inner' => $sBlockId . '_form_inner',
	'postUrl' => POST_FORM_ACTION_URI,
	'ajaxUrl' => \CUtil::JSEscape($comp->__component->GetPath() . '/ajax.php'),
];

//////////////////////////////////////////

?>

<script>
(function () {

	<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
	BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

	BX.message({
		SPPD_FILE_COUNT: '<?=Loc::getMessage('SPPD_FILE_COUNT')?>',
		SPPD_FILE_NOT_SELECTED: '<?=Loc::getMessage('SPPD_FILE_NOT_SELECTED')?>'
	});

	new SalePersonalProfileAdd(
		{
			form: <?=\Bitrix\Main\Web\Json::encode($form)?>,
			personType: <?=\Bitrix\Main\Web\Json::encode($personType)?>,
		}
	);
}());
</script>
