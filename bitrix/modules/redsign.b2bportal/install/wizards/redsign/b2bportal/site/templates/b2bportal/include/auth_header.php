<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

/**
 * @var CMain $APPLICATION
 * @var array $arSiteData
 * @var string $curPage
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


Loc::loadMessages(__FILE__);

$APPLICATION->RestartBuffer();

if (!Loader::includeModule('redsign.b2bportal'))
{
	ShowError(Loc::getMessage('RS_ERROR_MODULE_NOT_INSTALLED'));
	die();
}

$sBodyClass = '';
$sBodyClass .= ' kt-login-v2--enabled';
$sBodyClass .= ' kt-header--static';
$sBodyClass .= ' kt-header-mobile--fixed';
$sBodyClass .= ' kt-subheader--enabled';
$sBodyClass .= ' kt-subheader--transparent';
$sBodyClass .= ' kt-aside--enabled';
$sBodyClass .= ' kt-aside--fixed';
$sBodyClass .= ' kt-page--loading';

$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/css/pages/login/login-v2.css');
$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/css/pages/wizards/wizard-v3.css');

?><!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
<?php
$APPLICATION->IncludeFile(
	SITE_DIR . "include/auth_head_begin.php",
	array(),
	array('MODE' => 'html')
);
?>

<!--begin::Fonts -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
	WebFont.load({
		google: {
			"families":[
				// "Poppins:300,400,500,600,700"
				"Roboto:300,400,500,600,700",
				"Montserrat:300,400,500,600,700"
			]
		},
		active: function() {
			sessionStorage.fonts = true;
		}
	});
</script>
<!--end::Fonts -->

<title>
	<?php
	$APPLICATION->ShowTitle();
	if (
		$curPage != SITE_DIR . 'index.php' &&
		$arSiteData['SITE_NAME'] != ''
	) {
		echo ' | ' . $arSiteData['SITE_NAME'];
	}
	?>
</title>

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
var KTAppOptions = {
	"colors": {
		"state": {
			"brand": "#5578eb",
			"metal": "#c4c5d6",
			"light": "#ffffff",
			"accent": "#00c5dc",
			"primary": "#5867dd",
			"success": "#34bfa3",
			"info": "#36a3f7",
			"warning": "#ffb822",
			"danger": "#fd3995",
			"focus": "#9816f4"
		},
		"base": {
			"label": [
				"#c5cbe3",
				"#a1a8c3",
				"#3d4465",
				"#3e4466"
			],
			"shape": [
				"#f0f3ff",
				"#d9dffa",
				"#afb4d4",
				"#646c9a"
			]
		}
	}
};
</script>
<!-- end::Global Config -->

<!--begin::Custom -->
<?php
$APPLICATION->ShowHead();

$APPLICATION->IncludeFile(
	SITE_DIR . "include/auth_head_end.php",
	array(),
	array('MODE' => 'html')
);
?>
</head>
<body class="<?=$sBodyClass?>">
	<?php
	$APPLICATION->IncludeFile(
		SITE_DIR . "include/auth_body_begin.php",
		array(),
		array('MODE' => 'html')
	);

	// hide error in console
	?>
	<span class="kt-aside__brand-aside-toggler"></span>

	<div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid kt-grid--hor kt-login-v2" id="kt_login_v2">
			<!--begin::Item-->
			<div class="kt-grid__item kt-grid--hor">
				<!--begin::Heade-->
				<div class="kt-login-v2__head">
					<div class="kt-login-v2__logo">
						<a href="<?=SITE_DIR?>"><?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR . "include/logo_colors.php",
								"EDIT_TEMPLATE" => ""
							),
							false
						);?></a>
					</div>
					<?php $APPLICATION->ShowViewContent('rs_b2bportal_signup'); ?>
				</div>
				<!--begin::Head-->
			</div>
			<!--end::Item-->

			<!--begin::Item-->
			<div class="kt-grid__item kt-grid kt-grid--ver kt-grid__item--fluid">
