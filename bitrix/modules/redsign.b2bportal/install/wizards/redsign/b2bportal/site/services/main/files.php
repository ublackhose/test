<?php

/**
 * @var CDataInstallWizardStep $this
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!defined("WIZARD_SITE_ID") || !defined("WIZARD_SITE_DIR"))
    return;

function ___writeToAreasFile(string $path, string $text): void
{
    //if(file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS"))
    //    @chmod($abs_path, BX_FILE_PERMISSIONS);

    $fd = @fopen($path, "wb");
    if (!$fd)
        return;

    if(false === fwrite($fd, nl2br($text))) {
        fclose($fd);
        return;
    }

    fclose($fd);

    if (defined("BX_FILE_PERMISSIONS"))
        @chmod($path, BX_FILE_PERMISSIONS);
}

if (COption::GetOptionString("main", "upload_dir") == "")
    COption::SetOptionString("main", "upload_dir", "upload");

if (
    COption::GetOptionString("redsign.b2bportal", "wizard_installed", "N", WIZARD_SITE_ID) == "N"
    || WIZARD_INSTALL_DEMO_DATA
) {
    if (file_exists(WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/")) {
        CopyDirFiles(
            WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/",
            WIZARD_SITE_PATH,
            $rewrite = true,
            $recursive = true,
            $delete_after_copy = false
        );
    }
    COption::SetOptionString("redsign.b2bportal", "template_converted", "Y", "", WIZARD_SITE_ID);
} elseif (COption::GetOptionString("redsign.b2bportal", "template_converted", "N", WIZARD_SITE_ID) == "N") {
    CopyDirFiles(
        WIZARD_SITE_PATH . "/include/logo.php",
        WIZARD_SITE_PATH . "/include/logo_old.php",
        $rewrite = true,
        $recursive = true,
        $delete_after_copy = true
    );
    CopyDirFiles(
        WIZARD_SITE_PATH . "/include/logo_colors.php",
        WIZARD_SITE_PATH . "/include/logo_colors_old.php",
        $rewrite = true,
        $recursive = true,
        $delete_after_copy = true
    );

    COption::SetOptionString("redsign.b2bportal", "template_converted", "Y", "", WIZARD_SITE_ID);
}

$wizard =& $this->GetWizard();
// ___writeToAreasFile(WIZARD_SITE_PATH . "include/company_name.php", $wizard->GetVar("siteName"));
// ___writeToAreasFile(WIZARD_SITE_PATH . "include/copyright.php", $wizard->GetVar("siteCopy"));
// ___writeToAreasFile(WIZARD_SITE_PATH . "include/schedule.php", $wizard->GetVar("siteSchedule"));
// ___writeToAreasFile(WIZARD_SITE_PATH . "include/telephone.php", $wizard->GetVar("siteTelephone"));


if (COption::GetOptionString("redsign.b2bportal", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;

WizardServices::PatchHtaccess(WIZARD_SITE_PATH);

WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'action/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'auth/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'catalog/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'contacts/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'delivery/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'include/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'news/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'payment/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'personal/', ['SITE_DIR' => WIZARD_SITE_DIR]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'suppliers/', ['SITE_DIR' => WIZARD_SITE_DIR]);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '_index.php', ['SITE_DIR' => WIZARD_SITE_DIR]);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '.aside.menu.php', ['SITE_DIR' => WIZARD_SITE_DIR]);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '.footer.menu.php', ['SITE_DIR' => WIZARD_SITE_DIR]);

/*
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'about/', ['SALE_EMAIL' => $wizard->GetVar('shopEmail')]);
WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH . 'about/delivery/', ['SALE_PHONE' => $wizard->GetVar('siteTelephone')]);

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '/index.php', ['SITE_DIR' => WIZARD_SITE_DIR]);
*/

// #SITE_PHONE#
$sitePhone = $wizard->GetVar('siteTelephone');
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . 'include/pdf_contacts.php', ['SITE_PHONE' => $sitePhone]);

// #SITE_PHONE_URL#
$sitePhoneUrl = preg_replace('/\D/', '', $sitePhone);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . 'include/pdf_contacts.php', ['SITE_PHONE_URL' => $sitePhoneUrl]);

// #SITE_SMALL_ADDRESS#
$smallAdress = $wizard->GetVar('shopLocation') . ', ' . $wizard->GetVar('shopAdr');
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . 'include/pdf_contacts.php', ['SITE_SMALL_ADDRESS' => $smallAdress]);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '/.section.php', ['SITE_DESCRIPTION' => htmlspecialcharsbx($wizard->GetVar('siteMetaDescription'))]);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . '/.section.php', ['SITE_KEYWORDS' => htmlspecialcharsbx($wizard->GetVar('siteMetaKeywords'))]);

if (CModule::IncludeModule('sale'))
{
    $addResult = \Bitrix\Main\UserConsent\Internals\AgreementTable::add([
        "CODE" => "sale_default",
        "NAME" => GetMessage("WIZ_DEFAULT_USER_CONSENT_NAME"),
        "TYPE" => \Bitrix\Main\UserConsent\Agreement::TYPE_STANDARD,
        "LANGUAGE_ID" => LANGUAGE_ID,
        "DATA_PROVIDER" => \Bitrix\Sale\UserConsent::DATA_PROVIDER_CODE
    ]);
    if ($addResult->isSuccess())
    {
        CWizardUtil::ReplaceMacros(
            WIZARD_SITE_PATH . "personal/order/make/index.php",
            ['USER_CONSENT_ID' => $addResult->getId()]
        );
    }
}

$arUrlRewrite = [];
if (file_exists(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php")) {
    include(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php");
}

$arNewUrlRewrite = [
    [
        "CONDITION" => "#^" . WIZARD_SITE_DIR . "news/#",
        "RULE" => "",
        "ID" => "bitrix:news",
        "PATH" => WIZARD_SITE_DIR . "news/index.php",
    ],
    [
        "CONDITION" => "#^" . WIZARD_SITE_DIR . "action/#",
        "RULE" => "",
        "ID" => "bitrix:news",
        "PATH" => WIZARD_SITE_DIR . "action/index.php",
    ],
    [
        "CONDITION" => "#^" . WIZARD_SITE_DIR . "catalog/#",
        "RULE" => "",
        "ID" => "bitrix:catalog",
        "PATH" => WIZARD_SITE_DIR . "catalog/index.php",
    ],
    [
        "CONDITION" => "#^" . WIZARD_SITE_DIR . "personal/#",
        "RULE" => "",
        "ID" => "bitrix:sale.personal.section",
        "PATH" => WIZARD_SITE_DIR . "personal/index.php",
    ],
    [
        "CONDITION" => "#^" . WIZARD_SITE_DIR . "personal/kompred/#",
        "RULE" => "",
        "ID" => "redsign:kompred",
        "PATH" => WIZARD_SITE_DIR . "personal/kompred/index.php",
    ],
];

foreach ($arNewUrlRewrite as $arUrl) {
    if (!in_array($arUrl, $arUrlRewrite)) {
        \Bitrix\Main\UrlRewriter::add(WIZARD_SITE_ID, $arUrl);
    }
}
