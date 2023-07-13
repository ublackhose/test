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

$arResult['AUTH_REGISTER_URL'] = !empty($arResult['AUTH_REGISTER_URL']) ? $arResult['AUTH_REGISTER_URL'] : '?register=yes';

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
				<h3><?=Loc::getMessage('AUTH_TITLE')?></h3>
			</div>

			<form class="kt-login-v2__form kt-form" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
				<?php if (!empty($arParams["~AUTH_RESULT"])): ?>
				<div class="form-group form-group-last">
					<div class="alert alert-secondary" role="alert">
						<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
						<div class="alert-text">
							<?php
							if (is_array($arParams["~AUTH_RESULT"]))
							{
								echo $arParams["~AUTH_RESULT"]['MESSAGE'];
							}
							else
							{
								echo $arParams["~AUTH_RESULT"];
							}
							?>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<?php
				if (strlen($arResult["BACKURL"]) > 0)
				{
					?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?
				}
				?>
				<input type="hidden" name="AUTH_FORM" value="Y">
				<input type="hidden" name="TYPE" value="SEND_PWD">

				<div class="form-group">
					<?=Loc::getMessage('sys_forgot_pass_label')?>
				</div>

				<div class="form-group">
					<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult['LAST_LOGIN']?>" class="form-control" autocomplete="off" placeholder="<?=Loc::getMessage('sys_forgot_pass_login1')?>">
					<input type="hidden" name="USER_EMAIL" />
					<small class="form-text text-muted"><?=Loc::getMessage('sys_forgot_pass_note_email')?></small>
				</div>

				<?php if ($arResult['PHONE_REGISTRATION']): ?>
				<div class="form-group">
					<label><?=Loc::getMessage('sys_forgot_pass_phone')?></label>
					<input type="text" name="USER_PHONE_NUMBER" maxlength="50" value="" class="form-control" autocomplete="off" placeholder="">
					<small class="form-text text-muted"><?=Loc::getMessage('sys_forgot_pass_note_phone')?></small>
				</div>
				<?php endif; ?>

				<?php if ($arResult['USE_CAPTCHA']): ?>
				<div class="form-group form-group-last">
					<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
					<label><?=Loc::getMessage('system_auth_captcha')?></label>
					<div class="mb-2"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
					<input type="text" name="captcha_word" maxlength="50" value="" class="form-control">
				</div>
				<?php endif; ?>

				<div class="kt-login-v2__actions">
					<a class="kt-link kt-link--brand" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
					<input class="btn btn-brand btn-elevate btn-pill" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
				</div>

			</form>

			<script type="text/javascript">
			document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
			document.bform.USER_LOGIN.focus();
			</script>
		</div>
	</div>
	<div class="kt-login-v2__image">
		<img src="<?=$templateFolder?>/images/bg_icon.svg" alt="">
	</div>
</div>
<!--end::Body-->

<?php
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_footer.php';
