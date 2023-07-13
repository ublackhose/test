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
				<h3><?=Loc::getMessage('AUTH_TITLE')?></h3>
			</div>

			<!--begin::Form-->
			<form class="kt-login-v2__form kt-form" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" autocomplete="off">

				<input type="hidden" name="AUTH_FORM" value="Y" />
				<input type="hidden" name="TYPE" value="AUTH" />

				<?php if (strlen($arResult["BACKURL"]) > 0): ?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?php endif; ?>

				<?php foreach ($arResult["POST"] as $key => $value): ?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?php endforeach; ?>

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
				<?php endif;?>

				<?php if (!empty($arParams["ERROR_MESSAGE"])): ?>
				<div class="form-group form-group-last">
					<div class="alert alert-secondary" role="alert">
						<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
						<div class="alert-text">
							<?php
							if (is_array($arParams["ERROR_MESSAGE"]))
							{
								echo implode('<br>', $arParams["ERROR_MESSAGE"]);
							}
							else
							{
								echo $arParams["ERROR_MESSAGE"];
							}
							?>
						</div>
					</div>
				</div>
				<?php endif;?>

				<div class="form-group">
					<input class="form-control" type="text" name="USER_LOGIN" maxlength="255" placeholder="<?=Loc::getMessage("AUTH_LOGIN")?>" autocomplete="off">
				</div>

				<div class="form-group">
					<?php if ($arResult["SECURE_AUTH"]): ?>
						<div class="input-group">
							<input class="form-control" type="password" name="USER_PASSWORD" maxlength="255" placeholder="<?=Loc::getMessage("AUTH_PASSWORD")?>" autocomplete="off">
							<div class="input-group-append" id="bx_auth_secure" style="display:none;">
								<span class="input-group-text" id="basic-addon2" title="<?=Loc::getMessage("AUTH_SECURE_NOTE")?>"><i class="fa fa-lock"></i></span>
							</div>
							<noscript>
							<span class="form-text text-muted"><?=Loc::getMessage("AUTH_NONSECURE_NOTE")?></span>
							</noscript>
							<script type="text/javascript">
							document.getElementById('bx_auth_secure').style.display = '';
							</script>
						</div>
					<?php else: ?>
						<input class="form-control" type="password" name="USER_PASSWORD" maxlength="255" placeholder="<?=Loc::getMessage("AUTH_PASSWORD")?>" autocomplete="off">
					<?php endif;?>
				</div>

				<?php if ($arResult['CAPTCHA_CODE']): ?>
				<div class="form-group">
					<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
					<div><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
					<input class="form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" placeholder="<?=Loc::getMessage("AUTH_CAPTCHA_PROMT")?>" />
				</div>
				<?php endif;?>

				<?php if ($arResult['STORE_PASSWORD'] == 'Y'): ?>
				<div class="form-group form-group-last">
					<div class="form-control-plaintext">
						<label class="kt-checkbox mb-0">
							<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" checked="checked"> <?=Loc::getMessage("AUTH_REMEMBER_ME")?>
							<span></span>
						</label>
					</div>
				</div>
				<?php endif;?>

				<!--begin::Action-->
				<div class="kt-login-v2__actions">
					<?php if ($arParams["NOT_SHOW_LINKS"] != "Y"): ?>
						<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="kt-link kt-link--brand"><?=Loc::getMessage("AUTH_FORGOT_PASSWORD_2")?></a>
					<?php else: ?>
						<span></span>
					<?php endif; ?>
					<button type="submit" class="btn btn-brand btn-elevate btn-pill" name="Login" value="<?=Loc::getMessage("AUTH_AUTHORIZE")?>"><?=Loc::getMessage("AUTH_AUTHORIZE")?></button>
				</div>
				<!--end::Action-->

			</form>
			<!--end::Form-->
		</div>
	</div>
	<!--end::Wrapper-->

	<!--begin::Image-->
	<div class="kt-login-v2__image">
		<img src="<?=$templateFolder?>/images/bg_icon.svg" alt="">
	</div>
	<!--begin::Image-->

</div>
<!--end::Body-->

<script type="text/javascript">
<?php if (strlen($arResult['LAST_LOGIN']) > 0): ?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?php else: ?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?php endif; ?>
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_footer.php';