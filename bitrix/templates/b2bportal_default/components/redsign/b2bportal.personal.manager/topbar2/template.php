<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignB2BPortalPersonalManager $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!$arResult['HAS_MANAGER'] || empty($arResult['DATA']))
{
	return;
}
$props = $arResult['DATA']['PROPS'];
?>
<div class="kt-header__topbar-item kt-header__topbar-item--manager d-none d-sm-flex">
	<div class="kt-header__topbar-wrapper">
		<button type="button" class="btn btn-metal dropdown-toggle" data-toggle="dropdown" data-offset="0px,10px" aria-expanded="true">
			<?=Loc::getMessage('RS_B2BPORTAL_PM_MANAGER')?>: <?=$props['NAME'] ?? ''?>
		</button>
		<div class="dropdown-menu dropdown-menu-md dropdown-menu-fit dropdown-menu-anim" x-placement="bottom-start">
			<div class="kt-user-card kt-margin-b-50 kt-margin-b-30-tablet-and-mobile" style="background-image: url('<?=$templateFolder?>/images/head_bg_sm.jpg');">
				<div class="kt-user-card__wrapper">
					<?php if (!empty($props['PHOTO'])): ?>
					<div class="kt-user-card__pic">
						<img alt="<?=$props['NAME']?>" al src="<?=$props['PHOTO']?>">
					</div>
					<?php endif; ?>
					<div class="kt-user-card__details">
						<div class="kt-user-card__name"><?=$props['NAME'] ?? ''?></div>
						<div class="kt-user-card__position"><?=Loc::getMessage('RS_B2BPORTAL_PM_MANAGER')?></div>
					</div>
				</div>
			</div>
			<div class="kt-nav mb-3">
				<div class="pl-4 pr-4">
					<?php if (!empty($props['PHONE_NUMBER'])): ?>
					<div class="mb-3"><i class="flaticon2-phone kt-font-brand mr-3 lh-0 align-middle"></i><a href="tel:<?=$props['PHONE_NUMBER_PREPARED']?>"><?=$props['PHONE_NUMBER']?></a></div>
					<?php endif; ?>

					<?php if (!empty($props['EMAIL'])): ?>
					<div class="mb-3"><i class="socicon-mail kt-font-danger mr-3 lh-0 align-middle"></i><a href="mailto:<?=$props['EMAIL']?>"><?=$props['EMAIL']?></a></div>
					<?php endif; ?>

					<?php if (!empty($props['SKYPE'])): ?>
					<div class="mb-3"><i class="socicon-skype kt-font-info mr-3 lh-0 align-middle"></i><a href="skype:<?=$props['SKYPE']?>"><?=$props['SKYPE']?></a></div>
					<?php endif; ?>

					<?php if (!empty($props['TELEGRAM'])): ?>
					<div class="mb-3"><i class="socicon-telegram kt-font-info mr-3 lh-0 align-middle"></i><a href="https://t.me/<?=$props['TELEGRAM']?>"><?=$props['TELEGRAM']?></a></div>
					<?php endif; ?>

					<?php if (!empty($props['WHATSAPP'])): ?>
					<div class="mb-3"><i class="socicon-whatsapp kt-font-info mr-3 lh-0 align-middle"></i><a href=" https://wa.me/<?=$props['WHATSAPP_PREPARED']?>"><?=$props['WHATSAPP']?></a></div>
					<?php endif; ?>

					<?php if (!empty($props['VIBER'])): ?>
					<div class="mb-3"><i class="socicon-viber kt-font-info mr-3 lh-0 align-middle"></i><a href="viber://chat?number=<?=$props['VIBER_PREPARED']?>"><?=$props['VIBER']?></a></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>