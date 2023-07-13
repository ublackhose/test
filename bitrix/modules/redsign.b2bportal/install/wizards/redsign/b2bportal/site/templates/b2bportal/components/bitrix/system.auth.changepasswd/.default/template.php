<?php

use Bitrix\Main\Localization\loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_header.php';

$this->SetViewTarget('rs_b2bportal_signup');
?>
<div class="kt-login-v2__signup">
	<span><?=Loc::getMessage('AUTH_SIGN_UP')?></span>
	<a href="<?=$arResult['AUTH_REGISTER_URL']?>" class="kt-link kt-font-brand"><?=Loc::getMessage('AUTH_REG')?></a>
</div>
<?php $this->EndViewTarget(); ?>
<!--begin::Body-->
<div class="kt-login-v2__body">

	<!--begin::Wrapper-->
	<div class="kt-login-v2__wrapper">

		<div class="kt-login-v2__container">
			<div class="kt-login-v2__title">
				<h3><?=Loc::getMessage('AUTH_CHANGE_PASSWORD')?></h3>
			</div>
			<div class="kt-login-v2__form">
				<?php if (!empty($arParams['~AUTH_RESULT'])): ?>
					<div class="form-group form-group-last">
						<div class="alert alert-secondary" role="alert">
							<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
							<div class="alert-text">
								<?php
								if (is_array($arParams['~AUTH_RESULT']))
								{
									echo $arParams['~AUTH_RESULT']['MESSAGE'];
								}
								else
								{
									echo $arParams['~AUTH_RESULT'];
								}
								?>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<form class="kt-form" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">

					<?if (strlen($arResult["BACKURL"]) > 0): ?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<? endif ?>

					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="CHANGE_PWD">

					<?php if ($arResult["PHONE_REGISTRATION"]): ?>

						<div class="form-group">
							<label><?=Loc::getMessage('AUTH_PHONE')?></label>
							<input type="text" value="<?=$arResult['LAST_LOGIN']?>" class="form-control" disabled="disabled">
							<input type="hidden" name="USER_PHONE_NUMBER" value="<?=htmlspecialcharsbx($arResult['USER_PHONE_NUMBER'])?>" />
						</div>

						<div class="form-group">
							<label><?=Loc::getMessage('AUTH_CHECK_PASSCODE')?></label>
							<input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult['USER_CHECKWORD']?>" class="form-control" autocomplete="off" placeholder="">
						</div>

					<?php else: ?>

						<div class="form-group">
							<label><?=Loc::getMessage('AUTH_LOGIN')?></label>
							<input type="text" value="<?=$arResult['LAST_LOGIN']?>" class="form-control" disabled="disabled">
							<input type="hidden" name="USER_LOGIN" maxlength="50" value="<?=$arResult['LAST_LOGIN']?>" class="form-control" autocomplete="off" placeholder="">
						</div>

						<div class="form-group">
							<label><?=Loc::getMessage('AUTH_CHECKWORD')?></label>
							<input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult['USER_CHECKWORD']?>" class="form-control" autocomplete="off" placeholder="">
						</div>

					<?php endif; ?>

					<div class="form-group">
						<label><?=Loc::getMessage('AUTH_NEW_PASSWORD_REQ')?></label>
						<input type="text" name="USER_PASSWORD" maxlength="50" value="<?=$arResult['USER_PASSWORD']?>" class="form-control" autocomplete="off" placeholder="">
					</div>

					<div class="form-group">
						<label><?=Loc::getMessage('AUTH_NEW_PASSWORD_CONFIRM')?></label>
						<input type="text" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult['USER_CONFIRM_PASSWORD']?>" class="form-control" autocomplete="off" placeholder="">
					</div>

					<?php if ($arResult['USE_CAPTCHA'] == 'Y'): ?>
					<div class="form-group">
						<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
						<label><?=Loc::getMessage('CAPTCHA_REGF_PROMT')?></label>
						<div><img class="mb-2" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" /></div>
						<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" />
					</div>
					<?php endif; ?>

					<div class="kt-form__actions mb-5">
						<input class="btn btn-primary" type="submit" name="change_pwd" value="<?=Loc::getMessage('AUTH_CHANGE')?>" />
					</div>

					<p><a class="kt-link kt-link--brand" href="<?=$arResult['AUTH_AUTH_URL']?>"><?=Loc::getMessage('AUTH_AUTH')?></a></p>

				</form>

				<script type="text/javascript">
				document.bform.USER_LOGIN.focus();
				</script>

			</div>
		</div>

	</div>
	<div class="kt-login-v2__image">
		<img src="<?=$templateFolder?>/images/bg_icon.svg" alt="">
	</div>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_footer.php';