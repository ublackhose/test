<?php

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


$portlet = new Portlet();

$portlet->body(function () use ($arResult, $APPLICATION) {

	ShowError($arResult["strProfileError"]);
	?>

	<form class="kt-form" method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">

		<?=$arResult["BX_SESSION_CHECK"]?>
		<input type="hidden" name="lang" value="<?=LANG?>" />
		<input type="hidden" name="ID" value="<?=$arResult["ID"]?>" />
		<input type="hidden" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" />

		<?php if ($arResult['DATA_SAVED'] == 'Y'): ?>
		<div class="form-group form-group-last">
			<div class="alert alert-secondary" role="alert">
				<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
				<div class="alert-text"><?=Loc::getMessage("PROFILE_DATA_SAVED")?></div>
			</div>
		</div>
		<?php endif; ?>

		<?php if (!in_array(LANGUAGE_ID, array('ru', 'ua'))): ?>
		<div class="form-group">
			<label><?=Loc::getMessage('main_profile_title')?></label>
			<input class="form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
		</div>
		<?php endif; ?>

		<div class="form-group">
			<label><?=Loc::getMessage('NAME')?></label>
			<input class="form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
		</div>

		<div class="form-group">
			<label><?=Loc::getMessage('LAST_NAME')?></label>
			<input class="form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
		</div>

		<div class="form-group">
			<label><?=Loc::getMessage('SECOND_NAME')?></label>
			<input class="form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
		</div>

		<div class="form-group">
			<label><?=Loc::getMessage('EMAIL')?></label>
			<input class="form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
		</div>

		<?php if ($arResult['CAN_EDIT_PASSWORD']): ?>
		<div class="form-group">
			<label><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
			<input class=" form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
		</div>
		<div class="form-group">
			<label><?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?></label>
			<input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
		</div>
		<?php endif; ?>

		<div class="kt-form__actions">
			<input type="submit" name="save" class="btn btn-primary main-profile-submit" value="<?=(($arResult["ID"] > 0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
			<input type="submit" class="btn btn-default" name="reset" value="<?=GetMessage("MAIN_RESET")?>">
		</div>

	</form>

	<?php
});

$portlet->render();
