<?php

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!CModule::IncludeModule("iblock"))
    return;

if (COption::GetOptionString('redsign.b2bportal', 'wizard_installed', 'N', WIZARD_SITE_ID) == 'Y' && !WIZARD_INSTALL_DEMO_DATA)
    return;

$arTypes = [
    'catalog' => [
        'ID' => 'catalog',
        'SECTIONS' => 'Y',
        'IN_RSS' => 'N',
        'SORT' => '100',
        'LANG' => [],
    ],
    'offers' => [
        'ID' => 'offers',
        'SECTIONS' => 'Y',
        'IN_RSS' => 'N',
        'SORT' => '200',
        'LANG' => [],
    ],
    'presscenter' => [
        'ID' => 'presscenter',
        'SECTIONS' => 'N',
        'IN_RSS' => 'Y',
        'SORT' => '300',
        'LANG' => [],
    ],
    'system' => [
        'ID' => 'system',
        'SECTIONS' => 'Y',
        'IN_RSS' => 'N',
        'SORT' => '400',
        'LANG' => [],
    ],
    'banners' => [
        'ID' => 'banners',
        'SECTIONS' => 'Y',
        'IN_RSS' => 'N',
        'SORT' => '500',
        'LANG' => [],
    ],
];

$arLanguages = array();
$rsLanguage = CLanguage::GetList();
while ($arLanguage = $rsLanguage->Fetch())
    $arLanguages[] = $arLanguage["LID"];

$iblockType = new CIBlockType();
foreach ($arTypes as $arType) {
    $dbType = CIBlockType::GetList(array(), array("=ID" => $arType["ID"]));
    if ($dbType->Fetch())
        continue;

    foreach ($arLanguages as $languageID) {
        WizardServices::IncludeServiceLang("type.php", $languageID);

        $code = mb_strtoupper($arType["ID"]);
        $arType["LANG"][$languageID]["NAME"] = GetMessage($code . "_TYPE_NAME");
        $arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code . "_ELEMENT_NAME");

        if ($arType["SECTIONS"] == "Y")
            $arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code . "_SECTION_NAME");
    }

    $iblockType->Add($arType);
}

COption::SetOptionString('iblock', 'combined_list_mode', 'Y');
