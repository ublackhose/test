<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJs($templateFolder . '/js/RegistrationForm.js');

$jsData = [
	'personTypes' => $arResult['PERSON_TYPES'],
	'orderProps' => $arResult['ORDER_PROPS'],
	'orderPropsGroups' => $arResult['ORDER_PROPS_GROUPS'],
	'values' => $arResult['ORDER_PROPS_VALUES']
];
?>
<div style="display: none">
	<?
	// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it
	$APPLICATION->IncludeComponent(
		'bitrix:sale.location.selector.steps',
		'.default',
		array(),
		false
	);
	$APPLICATION->IncludeComponent(
		'bitrix:sale.location.selector.search',
		'.default',
		array(),
		false
	);
	?>
</div>

<div class="kt-wizard-v3" id="registration_form" data-ktwizard-state="step-first">

	<!--begin: Form Wizard Nav -->
	<div class="kt-wizard-v3__nav">
		<div class="kt-wizard-v3__nav-line"></div>
		<div class="kt-wizard-v3__nav-items kt-wizard-v3__nav-items--clickable">
			<div class="kt-wizard-v3__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
				<span>1</span>
				<i class="fa fa-check"></i>
				<div class="kt-wizard-v3__nav-label"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.STEP.ACCOUNT')?></div>
			</div>
			<div class="kt-wizard-v3__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
				<span>2</span>
				<i class="fa fa-check"></i>
				<div class="kt-wizard-v3__nav-label"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.STEP.COMPANY')?></div>
			</div>
			<div class="kt-wizard-v3__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="pending">
				<span>3</span>
				<i class="fa fa-check"></i>
				<div class="kt-wizard-v3__nav-label"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.STEP.PRIVACY')?></div>
			</div>
		</div>
	</div>
	<!--end: Form Wizard Nav -->

	<!--begin: Form Wizard Form-->
	<form class="kt-form" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform" enctype="multipart/form-data">
		<?php if (strlen($arResult['BACKURL']) > 0): ?>
		<input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>" />
		<?php endif; ?>

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

		<!--begin: Form Wizard Step 1-->
		<div class="kt-wizard-v3__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
			<div class="kt-heading kt-heading--md"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.STEP.ACCOUNT')?></div>
			<div class="kt-separator kt-separator--height-xs"></div>
			<div class="kt-form__section kt-form__section--first">
				<div class="row">

					<div class="col-lg-6 form-group ">
						<label><?=Loc::getMessage('AUTH_LOGIN')?> <span class="text-danger">*</span></label>
						<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult['USER_LOGIN']?>" class="form-control" required>
					</div>

					<?php if ($arResult['EMAIL_REGISTRATION']): ?>
						<div class="col-lg-6 form-group ">
						<label>
							<?=Loc::getMessage('AUTH_EMAIL')?>
							<?php if ($arResult['EMAIL_REQUIRED'] == '1'): ?>
								<span class="text-danger">*</span>
							<?php endif; ?>
						</label>
						<input type="email" name="USER_EMAIL" maxlength="255" value="<?=$arResult['USER_EMAIL']?>" class="form-control" autocomplete="off" <?=($arResult['EMAIL_REQUIRED'] == '1' ? ' required' : '')?>>
						<?php if ($arResult['USE_EMAIL_CONFIRMATION'] === 'Y'):?>
							<span class="form-text text-muted"><i class="flaticon-warning kt-font-brand"></i> <?=Loc::getMessage("AUTH_EMAIL_WILL_BE_SENT")?></span>
						<?php endif;?>
					</div>
					<?php endif;?>

					<?php if ($arResult['PHONE_REGISTRATION']): ?>
					<div class="col-lg-6 form-group ">
						<label>
							<?=Loc::getMessage('AUTH_PHONE')?>
							<?php if ($arResult['PHONE_REQUIRED'] == '1'): ?>
								<span class="text-danger">*</span>
							<?php endif; ?>
						</label>
						<input type="text" name="USER_PHONE_NUMBER" maxlength="50" value="<?=$arResult['USER_PHONE_NUMBER']?>" class="form-control js-inputmask" autocomplete="off"<?=($arResult['PHONE_REQUIRED'] == '1' ? ' required' : '')?>">
					</div>
					<?php endif;?>

					</div>

					<div class="row">
					<div class="col-lg-6 form-group">
						<label><?=Loc::getMessage('AUTH_NAME')?></label>
						<input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult['USER_NAME']?>" class="form-control" autocomplete="off" placeholder="">
					</div>
					<div class="col-lg-6 form-group">
						<label><?=Loc::getMessage('AUTH_LAST_NAME')?></label>
						<input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult['USER_LAST_NAME']?>" class="form-control" autocomplete="off" placeholder="">
					</div>
					</div>

					<div class="row">
					<div class="col-lg-6 form-group ">
						<label><?=Loc::getMessage('AUTH_PASSWORD_REQ')?> <span class="text-danger">*</span></label>
						<?php if ($arResult['SECURE_AUTH']): ?>
							<div class="input-group">
								<input
									class="form-control"
									type="password"
									id="USER_PASSWORD"
									name="USER_PASSWORD"
									<?php if (isset($arResult['GROUP_POLICY']['PASSWORD_LENGTH'])): ?>
										minlength="<?=$arResult['GROUP_POLICY']['PASSWORD_LENGTH']?>"
									<?php endif; ?>
									maxlength="255"
									placeholder="<?=Loc::getMessage('AUTH_PASSWORD')?>"
									autocomplete="off"
									required
								>
								<div class="input-group-append" id="bx_auth_secure" style="display:none;">
									<span class="input-group-text" id="basic-addon2" title="<?=Loc::getMessage('AUTH_SECURE_NOTE')?>">
										<i class="fa fa-lock"></i>
									</span>
								</div>
								<noscript>
								<span class="form-text text-muted"><?=Loc::getMessage('AUTH_NONSECURE_NOTE')?></span>
								</noscript>
								<script type="text/javascript">
								document.getElementById('bx_auth_secure').style.display = 'flex';
								</script>
							</div>
						<?php else: ?>
							<input
								type="password"
								name="USER_PASSWORD"
								id="USER_PASSWORD"
								<?php if (isset($arResult['GROUP_POLICY']['PASSWORD_LENGTH'])): ?>
									minlength="<?=$arResult['GROUP_POLICY']['PASSWORD_LENGTH']?>"
								<?php endif; ?>
								maxlength="255"
								class="form-control"
								autocomplete="off"
								placeholder=""
								required
							>
						<?php endif;?>
					</div>
					<div class="col-lg-6 form-group">
						<label><?=Loc::getMessage('AUTH_PASSWORD_CONFIM')?> <span class="text-danger">*</span></label>
						<input
							class="form-control"
							type="password"
							name="USER_CONFIRM_PASSWORD"
							<?php if (isset($arResult['GROUP_POLICY']['PASSWORD_LENGTH'])): ?>
								minlength="<?=$arResult['GROUP_POLICY']['PASSWORD_LENGTH']?>"
							<?php endif; ?>
							maxlength="255"
							placeholder=""
							required
						>
					</div>
				</div>
			</div>
		</div>
		<!--end: Form Wizard Step 1-->

		<!--begin: Form Wizard Step 2-->
		<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
			<div class="kt-heading kt-heading--md"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.STEP.COMPANY')?></div>
			<div class="kt-form__section kt-form__section--first">
				<div data-form="create_company"></div>
			</div>
		</div>
		<!--end: Form Wizard Step 2-->

		<!--begin: Form Wizard Step 3-->
		<div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
			<div class="kt-heading kt-heading--md"></div>
			<div class="kt-form__section kt-form__section--first">
				<?php if ($arResult['USE_CAPTCHA'] == 'Y'): ?>
					<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />

					<div class="form-group row">
						<div class="col-lg-6">
							<label for="captcha_word">
								<?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.CAPTCHA')?>
								(<a class="kt-link" href="#" onclick="B2BPortal.Captcha.updateSid(this.parentNode.form)"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.CAPTCHA_UPDATE_SID');?></a>)
							</label>
							<input id="captcha_word" class="form-control" type="text" name="captcha_word" maxlength="50" autocomplete="off" value="" placeholder="" />
						</div>
						<div class="col-lg-6">
							<label>&nbsp;</label>
							<div class="form-control-static"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult['CAPTCHA_CODE']?>" alt="CAPTCHA" style="width: 146px; height: 37px;" /></div>
						</div>
					</div>
				<?php endif; ?>

				<div class="form-group row">
					<div class="col-lg-12">
						<?$APPLICATION->IncludeComponent(
							'bitrix:main.userconsent.request',
							'',
							[
								'ID' => COption::getOptionString('main', 'new_user_agreement', ''),
								'IS_CHECKED' => "Y",
								'AUTO_SAVE' => "N",
								'IS_LOADED' => "Y",
								'ORIGINATOR_ID' => $arResult['AGREEMENT_ORIGINATOR_ID'],
								'ORIGIN_ID' => $arResult['AGREEMENT_ORIGIN_ID'],
								'INPUT_NAME' => $arResult['AGREEMENT_INPUT_NAME'],
								'REPLACE' => [
									"button_caption" => Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.BUTTONS.SUBMIT'),
								],
							]
						);?>
					</div>
				</div>
			</div>
		</div>
		<!--end: Form Wizard Step 3-->

		<!--begin: Form Actions -->
		<div class="kt-form__actions">
			<button class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
				<?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.BUTTONS.PREV')?>
			</button>
			<button class="btn btn-info btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
				<?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.BUTTONS.NEXT')?>
			</button>
			<button type="submit" class="btn btn-brand btn-elevate btn-pill kt-login-v2__submit-button" data-ktwizard-type="action-submit">
				<?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.BUTTONS.SUBMIT')?>
			</button>
		</div>
		<!--end: Form Actions -->
	</form>
	<!--end: Form Wizard Form-->
</div>

<script>
	(function() {
		<?php $messages = Loc::loadLanguageFile(__DIR__ . '/js_messages.php'); ?>
		BX.message(<?=\CUtil::PhpToJSObject($messages)?>);

		new B2BPortal.Components.RegistrationForm(
			document.getElementById('registration_form'),
			<?=Json::encode($jsData); ?>
		);
	}());
</script>