<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

/**
 * @version 1.14.0
 *
 * @var CMain $APPLICATION
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


Loc::loadMessages(__FILE__);

if (!Loader::includeModule('redsign.b2bportal'))
{
	ShowError(Loc::getMessage('RS_ERROR_MODULE_NOT_INSTALLED'));
	die();
}

$documentRoot = \Bitrix\Main\Application::getDocumentRoot();

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$curPage = $APPLICATION->GetCurPage(true);

$arSiteData = [];

// get site data
$cacheTime = 86400;
$cacheId = 'CSiteGetByID' . SITE_ID;
$cacheDir = '/siteData/' . SITE_ID . '/';

$cache = \Bitrix\Main\Data\Cache::createInstance();
if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
	$arSiteData = $cache->getVars();
} elseif ($cache->startDataCache()) {
	$arSiteData = array();

	$rsSites = CSite::GetByID(SITE_ID);
	if ($arSite = $rsSites->Fetch()) {
		$arSiteData['SITE_NAME'] = $arSite['SITE_NAME'];
	}

	if (empty($arSiteData)) {
		$cache->abortDataCache();
	}

	$cache->endDataCache($arSiteData);
}

$sBodyClass = '';
$sBodyClass .= ' kt-header--static';
if (!CTopPanel::shouldShowPanel())
{
	$sBodyClass .= ' kt-header-mobile--fixed';
}
$sBodyClass .= ' kt-subheader--enabled';
$sBodyClass .= ' kt-subheader--transparent';
$sBodyClass .= ' kt-aside--enabled';
$sBodyClass .= ' kt-aside--fixed';
$sBodyClass .= ' kt-offcanvas-panel--right';
// $sBodyClass .= ' kt-header__topbar--mobile-on';
if ($request->getCookieRaw('kt-aside-minimize') == 'Y')
{
	$sBodyClass .= ' kt-aside--minimize';
}

$isMain = ($APPLICATION->GetCurPage(true) == SITE_DIR . 'index.php');

$asset = Asset::getInstance();
?><!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<?php
	$APPLICATION->IncludeFile(
		SITE_DIR . "include/head_begin.php",
		array(),
		array('MODE' => 'html')
	);


	$asset->addString('<link href="' . CHTTP::URN2URI('/favicon.ico') . '" rel="shortcut icon" type="image/x-icon">');
	$asset->addString('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
	$asset->addString('<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit">');

	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/plugins/custom/fullcalendar/fullcalendar.bundle.css');
	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/plugins/global/plugins.bundle.css');
	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/css/style.bundle.css');
	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/theme/css/skins/aside/navy.css');

	CJSCore::Init(['ajax', 'ls']);
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/theme/plugins/global/plugins.bundle.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/theme/js/scripts.bundle.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/theme/plugins/custom/fullcalendar/fullcalendar.bundle.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/app/custom/general/components/forms/widgets/bootstrap-datepicker.js');

	\Bitrix\Main\UI\Extension::load(['main.polyfill.core', 'main.pageobject']);
	// $asset->addJs(SITE_TEMPLATE_PATH.'/assets/vendors/polyfill/polyfill.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendors/vue/vue.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/vendors/vue/vuex.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');
	$asset->addJs(SITE_TEMPLATE_PATH . '/assets/js/custom.js');
	$asset->addJs(SITE_DIR . 'assets/js/custom.js');

	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/main.css');
	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/print.css');
	$asset->addCss(SITE_TEMPLATE_PATH . '/assets/css/custom.css');
	$asset->addCss(SITE_DIR . 'assets/css/custom.css');
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


<!-- begin::Tuning Hack -->
<script>
	if (!('RS' in window))
		window.RS = {};
</script>
<!-- end::Tuning Hack -->

<!--begin::Custom -->
<?php
$APPLICATION->ShowHead();
?>

<!-- begin::bx.messages -->
<script>
	BX.message({
		'VUE.VGT_PAGINATION.ROWS_PER_PAGE_TEXT': '<?=CUtil::JSEscape(Loc::getMessage('VUE.VGT_PAGINATION.ROWS_PER_PAGE_TEXT'))?>',
		'VUE.VGT_PAGINATION.ALL': '<?=CUtil::JSEscape(Loc::getMessage('VUE.VGT_PAGINATION.ALL'))?>',
		'VUE.VGT_PAGINATION.NO_DATA_FOR_TABLE': '<?=CUtil::JSEscape(Loc::getMessage('VUE.VGT_PAGINATION.NO_DATA_FOR_TABLE'))?>',
		'RS_B2BPORTAL_STOCK_QUANTITY_REST': '<?=CUtil::JSEscape(Loc::getMessage('RS_B2BPORTAL_STOCK_QUANTITY_REST'))?>',
		'RS_B2BPORTAL_STOCKS_NOT_FOUND': '<?=CUtil::JSEscape(Loc::getMessage('RS_B2BPORTAL_STOCKS_NOT_FOUND'))?>',
	});
</script>
<!-- end::bx.messages -->

<?php
$APPLICATION->IncludeFile(
	SITE_DIR . "include/head_end.php",
	array(),
	array('MODE' => 'html')
);
?>
</head>
<body class="<?=$sBodyClass?>">

	<?php
	include($documentRoot . SITE_TEMPLATE_PATH . '/include/globals.php');

	if (Loader::includeModule('redsign.tuning'))
	{
		$APPLICATION->IncludeFile(
			SITE_DIR . "include/tuning/component.php",
			array(),
			array("MODE" => "html")
		);
	}

	$APPLICATION->IncludeFile(
		SITE_DIR . "include/body_begin.php",
		array(),
		array('MODE' => 'html')
	);
	?>

	<div id="panel"><?=$APPLICATION->ShowPanel()?></div>

	<?php
	include($documentRoot . SITE_TEMPLATE_PATH . '/include/header/main.php');
