<?php

/**
 * @var CMain $APPLICATION
 * @var bool $isMain
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$sTogglerClass = '';
$sTogglerClass .= ' kt-aside__brand-aside-toggler';
$sTogglerClass .= ' kt-aside__brand-aside-toggler--left';
if ($request->getCookieRaw('kt-aside-minimize') == 'Y')
{
	$sTogglerClass .= ' kt-aside__brand-aside-toggler--active';
}
?>
	<!-- begin::Page loader -->
	<!-- end::Page Loader -->
	<!-- begin:: Page -->
	<!-- begin:: Header Mobile -->
	<div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed " >
		<div class="kt-header-mobile__logo">
			<a href="<?=SITE_DIR?>">
				<?php
				$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => SITE_DIR . "include/logo.php",
						"EDIT_TEMPLATE" => ""
					),
					false
				);
				?>
			</a>
		</div>
		<div class="kt-header-mobile__toolbar">
			<button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
			<button class="kt-header-mobile__toolbar-topbar-toggler kt-header-mobile__toolbar-topbar-toggler--active" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
		</div>
	</div>
	<!-- end:: Header Mobile -->

	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
			<!-- begin:: Aside -->
			<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
			<div class="kt-aside kt-aside--fixed kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
				<!-- begin:: Aside -->
				<div class="kt-aside__brand kt-grid__item" id="kt_aside_brand">
					<div class="kt-aside__brand-logo">
						<a href="<?=SITE_DIR?>">
							<?php
							$APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"",
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => SITE_DIR . "include/logo.php",
									"EDIT_TEMPLATE" => ""
								),
								false
							);
							?>
						</a>
					</div>
					<div class="kt-aside__brand-tools">
						<button class="<?=$sTogglerClass?>" id="kt_aside_toggler" data-portlet-tool="reload"><span></span></button>
					</div>
				</div>
				<!-- end:: Aside -->
				<!-- begin:: Aside Menu -->
				<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
					<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500" >
						<?php
						$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR . "include/menu.aside.php",
								"EDIT_TEMPLATE" => ""
							),
							false
						);
						?>
					</div>
				</div>
				<!-- end:: Aside Menu -->
			</div>
			<!-- end:: Aside -->
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper">
				<!-- begin:: Header -->
				<div id="kt_header" class="kt-header kt-grid__item " data-ktheader-minimize="on">
					<div class="kt-container kt-container--fluid ">

						<!-- begin:: Topbar -->
						<div class="kt-header__topbar">

							<div class="kt-header__topbar-item kt-header__topbar-item--search">
								<div class="kt-header__topbar-wrapper">
									<?php
									$APPLICATION->IncludeFile(
										SITE_DIR . "include/quicksearch.php",
										array(),
										array(
											'SHOW_BORDER' => false
										)
									);
									?>
								</div>
							</div>

							<?php
							$APPLICATION->IncludeFile(
								SITE_DIR . 'include/personal_manager.php',
								array(),
								array(
									'SHOW_BORDER' => false
								)
							);
							?>

							<div class="kt-header__topbar-item">
								<div class="kt-header__topbar-wrapper">
									<?php
									$APPLICATION->IncludeComponent(
										"bitrix:main.include",
										"",
										array(
											"AREA_FILE_SHOW" => "file",
											"PATH" => SITE_DIR . "include/basket.php",
											"EDIT_TEMPLATE" => ""
										),
										false
									);
									?>
								</div>
							</div>

							<?php
							$APPLICATION->IncludeFile(
								SITE_DIR . 'include/system.auth.form.php',
								array(),
								array('MODE' => 'html')
							);
							?>
						</div>
					</div>
					<!-- end:: Topbar -->

					<!-- begin:: Subheader -->
					<div class="kt-container kt-container--fluid">
						<div class="kt-subheader kt-grid__item" id="kt_subheader">
							<div class="kt-subheader__main">
								<?php if (!$isMain): ?>
									<h1 class="kt-subheader__title"><?php $APPLICATION->ShowTitle(false)?></h1>
									<span class="kt-subheader__separator kt-hidden"></span>
									<?php
									$APPLICATION->IncludeFile(
										SITE_DIR . 'include/breadcrumb.php',
										array(),
										array('MODE' => 'html')
									);
									?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<!-- end:: Subheader -->

				</div>
				<!-- end:: Header -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
					<!-- begin:: Subheader -->
					<div class="kt-container kt-container--fluid ">
						<div class="kt-subheader kt-grid__item" id="kt_subheader">
							<div class="kt-subheader__main">
								<?php if (!$isMain): ?>
									<h3 class="kt-subheader__title"><?php $APPLICATION->ShowTitle(false); ?></h3>
									<span class="kt-subheader__separator kt-hidden"></span>
									<?php
									$APPLICATION->IncludeFile(
										SITE_DIR . 'include/breadcrumb.php',
										array(),
										array('MODE' => 'html')
									);
									?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<!-- begin:: Content -->
					<div class="kt-content kt-grid__item kt-grid__item--fluid" id="kt_content">
						<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">

							<?php
							function getPortlet(): string
							{
								/** @var $APPLICATION */
								global $APPLICATION;

								$sHTML = '';

								$offPortlet = $APPLICATION->GetProperty('off_portlet');

								if (empty($offPortlet))
								{
									$sHTML .= '<div class="kt-portlet">';
										$sHTML .= '<div class="kt-portlet__body">';
								}

								return $sHTML;
							}

							$APPLICATION->AddBufferContent('getPortlet');
