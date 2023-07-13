<?php

use Bitrix\Main\Localization\loc;
use Bitrix\Main\UI\Extension;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


CJSCore::Init(['phone_number']);

include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_header.php';

Extension::load(['redsign.b2bportal.captcha']);

if ($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}


$this->SetViewTarget('rs_b2bportal_signup');
?>
<div class="kt-login-v2__signup">
	<span><?=Loc::getMessage('AUTH_SIGN_IN')?></span>
	<a href="<?=$arResult['AUTH_AUTH_URL']?>" class="kt-link kt-font-brand"><?=Loc::getMessage('AUTH_AUTH')?></a>
</div>
<?php $this->EndViewTarget(); ?>

<div class="kt-login-v2__body justify-content-center">

	<!--begin::Wrapper-->
	<div class="kt-login-v2__wrapper">

		<div class="kt-login-v2__container mw-100">
			<div class="kt-login-v2__title">
				<h3><?=Loc::getMessage('AUTH_REGISTER_TITLE')?></h3>
			</div>
			<div class="kt-login-v2__forms">

				<div class="kt-login-v2__form">
					<?php if (!empty($arParams["~AUTH_RESULT"])): ?>
					<div class="form-group form-group-last">
						<div class="alert alert-secondary" role="alert">
							<div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
							<div class="alert-text">
								<?php
								if (is_array($arParams["~AUTH_RESULT"]))
								{
									if (is_array($arParams["~AUTH_RESULT"]['MESSAGE']))
									{
										echo implode('<br>', $arParams["~AUTH_RESULT"]['MESSAGE']);
									}
									else
									{
										echo $arParams["~AUTH_RESULT"]['MESSAGE'];
									}
								}
								else
								{
									echo $arParams["~AUTH_RESULT"];
								}

								if ($arResult['SHOW_EMAIL_SENT_CONFIRMATION'])
								{
									echo '<br>' . Loc::getMessage('AUTH_EMAIL_SENT');
								}
								?>
							</div>
						</div>

						<?php if ((!empty($arParams["AUTH_RESULT"]) && is_array($arParams['AUTH_RESULT']) && $arParams['AUTH_RESULT']['TYPE'] == 'OK')): ?>
							<div class="text-center">
								<a href="<?=$arResult['AUTH_AUTH_URL']?>" class="btn btn-primary"><?=Loc::getMessage('AUTH_AUTH');?></a>
								<a href="<?=SITE_DIR?>" class="btn btn-outline-primary"><?=Loc::getMessage('AUTH_BACK');?></a>
							</div>
						<?php endif; ?>
					</div>
					<?php endif;?>
				</div>

				<?php
				if (
					empty($arParams["AUTH_RESULT"]) ||
					(!empty($arParams["AUTH_RESULT"]) && is_array($arParams['AUTH_RESULT']) && $arParams['AUTH_RESULT']['TYPE'] != 'OK')
				)
				{
					?>
					<noindex>
					<div class="form-registration__container">
						<div class="form-registration__form">
						<?php
						if ($arResult['SHOW_SMS_FIELD'] == true)
						{
							include('form_mobile.php');
						}
						elseif (!$arResult['SHOW_EMAIL_SENT_CONFIRMATION'])
						{
							include('form_email.php');
						}
						?>
						</div>
					</div>
					</noindex>
					<?php
				}
				?>

			</div>
		</div>
	</div>
</div>
<!--end::Body-->

<?php
include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/include/auth_footer.php';