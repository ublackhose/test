<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignB2BPortalPersonalProfileSelect $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');
?>

<!--begin: personal company select -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
	<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
		<span class="kt-header__topbar-icon"><i class="flaticon2-user"></i></span>
	</div>
	<?php if ($arResult['FORM_TYPE'] == 'logout'): ?>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-md">
		<?php if ($arResult['USER']): ?>
		<div class="kt-user-card-v4 kt-user-card-v4--skin-light kt-notification-item-padding-x">
			<?php if (strlen($arResult['USER']['INITIALS']) > 0): ?>
			<div class="kt-user-card-v4__avatar">
				<div class="bg-primary text-white kt-user-card-v4__initials"><?=$arResult['USER']['INITIALS']?></div>
			</div>
			<?php endif; ?>
			<div class="kt-user-card-v4__name">
				<a href="<?=SITE_DIR?>personal/"><?=$arResult['USER']['LOGIN']?></a>
				<?php if (strlen($arResult['USER']['FULLNAME']) > 0): ?>
				<small><?=$arResult['USER']['FULLNAME']?></small>
				<?php endif; ?>
			</div>
			<?php if (!empty($arResult['PROFILES']) && !empty($arParams['ADD_COMPANY_URL'])): ?>
				<a href="<?=$arParams['ADD_COMPANY_URL']?>" class="btn btn-icon btn-circle btn-light-hover-primary kt-user-card-v4__button">
					<i class="flaticon2-add-1"></i>
				</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
			<ul class="kt-nav kt-nav--bold kt-nav--md-space kt-nav--v4">
			<?php if (!empty($arResult['PERSON_TYPES']) && !empty($arResult['PROFILES'])): ?>
				<?php foreach ($arResult['PERSON_TYPES'] as $arType): ?>
					<?php
					if (!$arType['HAVE_PROFILE'])
						continue;
					?>
					<li class="kt-nav__section">
						<span class="kt-nav__section-text"><?=$arType['NAME']?></span>
					</li>
					<?php foreach ($arResult['PROFILES'] as $arProfile): ?>
						<?php
						if ($arType['ID'] != $arProfile['PERSON_TYPE_ID'])
							continue;
						?>
						<li class="kt-nav__item<?=($arProfile['CHECKED'] == 'Y' ? ' active' : '')?>">
							<a href="#" class="kt-nav__link js-spps-select" data-id="<?=$arProfile['ID']?>">
								<i class="kt-nav__link-bullet kt-nav__link-bullet--dot"><span></span></i>
								<span class="kt-nav__link-text"><?=$arProfile['NAME']?></span>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php else: ?>

				<?php if (!empty($arParams['ADD_COMPANY_URL'])): ?>
					<li class="kt-nav__item">
						<a href="<?=$arParams['ADD_COMPANY_URL']?>" class="kt-nav__link">
							<span class="kt-nav__link-icon"><i class="flaticon2-add-1"></i></span>
							<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_SPPS_LINK_ADD_COMPANY')?></span>
						</a>
					</li>
				<?php endif; ?>

			<?php endif; ?>

			<li class="kt-nav__separator kt-nav__separator--fit"></li>

			<li class="kt-nav__custom kt-space-between">
				<a href="?logout=yes&<?=bitrix_sessid_get()?>" class="btn btn-label-brand btn-upper btn-sm btn-bold"><?=Loc::getMessage('RS_B2BPORTAL_SPPS_LINK_LOGOUT')?></a>
			</li>

		</ul>
	</div>
	<?php else: ?>
	<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-md">
		<ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
			<li class="kt-nav__item">
				<a href="<?=SITE_DIR?>auth/" class="kt-nav__link">
					<span class="kt-nav__link-icon"><i class="fa fa-key"></i></span>
					<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_SPPS_LINK_AUTH')?></span>
				</a>
			</li>
			<li class="kt-nav__item">
				<a href="<?=SITE_DIR?>auth/?register=yes" class="kt-nav__link">
					<span class="kt-nav__link-icon"><i class="fa fa-address-book"></i></span>
					<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_SPPS_LINK_REGISTER')?></span>
				</a>
			</li>
		</ul>
	</div>
	<?php endif; ?>
</div>
<!--end: personal company select -->

<script>
(function () {

	new SalePersonalProfileSelect();

}());
</script>