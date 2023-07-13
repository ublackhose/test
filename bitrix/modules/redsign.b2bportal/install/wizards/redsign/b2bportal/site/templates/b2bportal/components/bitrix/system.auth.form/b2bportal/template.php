<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

?>

<!--begin: User -->
<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
        <span class="kt-header__topbar-icon"><i class="flaticon2-user"></i></span>
    </div>
<?php if ($arResult['FORM_TYPE'] == 'logout'): ?>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-md">
        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">

            <?php if (!empty($arResult['USER_NAME'])): ?>
            <h6 class="dropdown-header mt-2"><?=$arResult['USER_LOGIN']?> (<?=$arResult['USER_NAME']?>)</h6>
            <?php endif; ?>

            <?php if (!empty($arParams['CURRENT_ORDERS_URL'])): ?>
            <li class="kt-nav__item">
                <a href="<?=$arParams['CURRENT_ORDERS_URL']?>" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-list-3"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('RS.B2BPORTAL.PERSONAL_MENU.CURRENT_ORDERS')?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (!empty($arResult['PROFILE_URL'])): ?>
            <li class="kt-nav__item">
                <a href="<?=$arResult['PROFILE_URL']?>" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-user-1"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('RS.B2BPORTAL.PERSONAL_MENU.PROFILE')?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (!empty($arParams['PROFILES_URL'])): ?>
            <li class="kt-nav__item">
                <a href="<?=$arParams['PROFILES_URL']?>" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-group"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('RS.B2BPORTAL.PERSONAL_MENU.PROFILES')?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (!empty($arParams['DOCS_URL'])): ?>
            <li class="kt-nav__item">
                <a href="<?=$arParams['DOCS_URL']?>" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-file-1"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('RS.B2BPORTAL.PERSONAL_MENU.DOCS')?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (!empty($arParams['CLAIMS_URL']) && IsModuleInstalled('support')): ?>
            <li class="kt-nav__item">
                <a href="<?=$arParams['CLAIMS_URL']?>" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="flaticon2-warning"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('RS.B2BPORTAL.PERSONAL_MENU.CLAIMS')?></span>
                </a>
            </li>
            <?php endif; ?>

            <li class="kt-nav__custom kt-margin-t-15">
                <a href="?logout=yes" class="btn btn-default btn-upper btn-font-dark btn-sm btn-bold"><?=Loc::getMessage('LOGOUT')?></a>
            </li>

        </ul>
    </div>
<?php else: ?>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-md">
        <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
            <li class="kt-nav__item">
                <a href="<?=SITE_DIR?>auth/" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="fa fa-key"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('AUTH')?></span>
                </a>
            </li>
            <li class="kt-nav__item">
                <a href="<?=SITE_DIR?>auth/?register=yes" class="kt-nav__link">
                    <span class="kt-nav__link-icon"><i class="fa fa-address-book"></i></span>
                    <span class="kt-nav__link-text"><?=Loc::getMessage('REGISTER')?></span>
                </a>
            </li>
        </ul>
    </div>
<?php endif; ?>
</div>
<!--end: User -->
