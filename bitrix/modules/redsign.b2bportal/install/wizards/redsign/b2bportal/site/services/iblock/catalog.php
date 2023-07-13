<?php

use Bitrix\Main;
use Bitrix\Main\Localization\LanguageTable;

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!CModule::IncludeModule("iblock") || !CModule::IncludeModule("catalog"))
    return;

if (COption::GetOptionString("redsign.b2bportal", "wizard_installed", "N", WIZARD_SITE_ID) == "Y" && !WIZARD_INSTALL_DEMO_DATA)
    return;

//catalog iblock import
$shopLocalization = $wizard->GetVar("shopLocalization");

/** @var \Bitrix\Main\DB\Connection $connection */
$connection = \Bitrix\Main\Application::getConnection();
$sqlHelper = $connection->getSqlHelper();

$datetimeEntity = new Main\DB\SqlExpression($sqlHelper->getCurrentDateTimeFunction());
$languages = [];
$languageIterator = LanguageTable::getList(array(
    'select' => array('ID'),
    'filter' => array('=ACTIVE' => 'Y')
));
while ($existLanguage = $languageIterator->fetch())
    $languages[$existLanguage['ID']] = mb_strtoupper($existLanguage['ID']);
unset($existLanguage, $languageIterator);
$whiteList = [
    'FULL_NAME' => true,
    'FORMAT_STRING' => true,
    'DEC_POINT' => true,
    'THOUSANDS_VARIANT' => true,
    'DECIMALS' => true
];

$iblockXMLFile = WIZARD_SERVICE_RELATIVE_PATH . "/xml/" . LANGUAGE_ID . "/catalog.xml";
$iblockXMLFilePrices = WIZARD_SERVICE_RELATIVE_PATH . "/xml/" . LANGUAGE_ID . "/catalog_prices.xml";
switch ($shopLocalization) {
    case 'ua':
        if (!\Bitrix\Currency\CurrencyManager::isCurrencyExist('UAH')) {
            $arFields = array(
                "CURRENCY" => "UAH",
                "AMOUNT" => 39.41,
                "AMOUNT_CNT" => 10,
                "SORT" => 400
            );
            CCurrency::Add($arFields);

            $data = \Bitrix\Currency\CurrencyClassifier::getCurrency('UAH', array_keys($languages));
            if (!empty($data)) {
                foreach ($languages as $languageId => $upperLanguageId) {
                    if (empty($data[$upperLanguageId]))
                        continue;
                    $fields = [
                        'LID' => $languageId,
                        'CURRENCY' => 'UAH',
                        'CREATED_BY' => null,
                        'MODIFIED_BY' => null,
                        'DATE_CREATE' => $datetimeEntity,
                        'TIMESTAMP_X' => $datetimeEntity,
                        'HIDE_ZERO' => 'Y',
                        'THOUSANDS_SEP' => null
                    ] + array_intersect_key($data[$upperLanguageId], $whiteList);
                    $fields['FORMAT_STRING'] = str_replace('#VALUE#', '#', $fields['FORMAT_STRING']);
                    $resultCurrencyLang = \Bitrix\Currency\CurrencyLangTable::add($fields);
                    unset($resultCurrencyLang);
                }
                unset($languageId, $upperLanguageId);
            }
            unset($data);
        }
        break;
    case 'bl':
        if (!\Bitrix\Currency\CurrencyManager::isCurrencyExist('BYR')) {
            $arFields = array(
                "CURRENCY" => "BYR",
                "AMOUNT" => 36.72,
                "AMOUNT_CNT" => 10000,
                "SORT" => 500
            );
            CCurrency::Add($arFields);

            $data = \Bitrix\Currency\CurrencyClassifier::getCurrency('BYR', array_keys($languages));
            if (!empty($data)) {
                foreach ($languages as $languageId => $upperLanguageId) {
                    if (empty($data[$upperLanguageId]))
                        continue;
                    $fields = [
                        'LID' => $languageId,
                        'CURRENCY' => 'BYR',
                        'CREATED_BY' => null,
                        'MODIFIED_BY' => null,
                        'DATE_CREATE' => $datetimeEntity,
                        'TIMESTAMP_X' => $datetimeEntity,
                        'HIDE_ZERO' => 'Y',
                        'THOUSANDS_SEP' => null
                    ] + array_intersect_key($data[$upperLanguageId], $whiteList);
                    $fields['FORMAT_STRING'] = str_replace('#VALUE#', '#', $fields['FORMAT_STRING']);
                    $resultCurrencyLang = \Bitrix\Currency\CurrencyLangTable::add($fields);
                    unset($resultCurrencyLang);
                }
                unset($languageId, $upperLanguageId);
            }
            unset($data);
        }
        break;
    default:
        break;
}

$iblockCode = "clothes_" . WIZARD_SITE_ID;
$iblockType = "catalog";

$rsIBlock = CIBlock::GetList(array(), array("XML_ID" => $iblockCode, "TYPE" => $iblockType));
$IBLOCK_CATALOG_ID = false;
if ($arIBlock = $rsIBlock->Fetch()) {
    $IBLOCK_CATALOG_ID = $arIBlock["ID"];
}
if (WIZARD_INSTALL_DEMO_DATA && $IBLOCK_CATALOG_ID) {
    $boolFlag = true;
    $arSKU = CCatalogSku::GetInfoByProductIBlock($IBLOCK_CATALOG_ID);
    if (!empty($arSKU)) {
        $boolFlag = CCatalog::UnLinkSKUIBlock($IBLOCK_CATALOG_ID);
        if (!$boolFlag) {
            $strError = "";
            if ($ex = $APPLICATION->GetException()) {
                $strError = $ex->GetString();
            } else {
                $strError = "Couldn't unlink iblocks";
            }
            //die($strError);
        }
        $boolFlag = CIBlock::Delete($arSKU['IBLOCK_ID']);
        if (!$boolFlag) {
            $strError = "";
            if ($ex = $APPLICATION->GetException()) {
                $strError = $ex->GetString();
            } else {
                $strError = "Couldn't delete offers iblock";
            }
            //die($strError);
        }
    }
    if ($boolFlag) {
        $boolFlag = CIBlock::Delete($IBLOCK_CATALOG_ID);
        if (!$boolFlag) {
            $strError = "";
            if ($ex = $APPLICATION->GetException()) {
                $strError = $ex->GetString();
            } else {
                $strError = "Couldn't delete catalog iblock";
            }
            //die($strError);
        }
    }
    if ($boolFlag) {
        $IBLOCK_CATALOG_ID = false;
    }
}


$dbResultList = CCatalogGroup::GetList(array(), array("BASE" => "Y"));
if (!($dbResultList->Fetch())) {
    $arFields = array();
    $rsLanguage = CLanguage::GetList();
    while ($arLanguage = $rsLanguage->Fetch()) {
        WizardServices::IncludeServiceLang("catalog.php", $arLanguage["ID"]);
        $arFields["USER_LANG"][$arLanguage["ID"]] = GetMessage("WIZ_PRICE_NAME");
    }
    $arFields["BASE"] = "Y";
    $arFields["SORT"] = 100;
    $arFields["NAME"] = "BASE";
    $arFields["XML_ID"] = "BASE";
    $arFields["USER_GROUP"] = array(1);
    $arFields["USER_GROUP_BUY"] = array(1);
    CCatalogGroup::Add($arFields);
}

if ($IBLOCK_CATALOG_ID == false) {
    $permissions = array(
        "1" => "X",
        "2" => "R"
    );
    $dbGroup = CGroup::GetList('', '', array("STRING_ID" => "sale_administrator"));
    if ($arGroup = $dbGroup->Fetch()) {
        $permissions[$arGroup["ID"]] = 'W';
    }
    $by = "";
    $order = "";
    $dbGroup = CGroup::GetList('', '', array("STRING_ID" => "content_editor"));
    if ($arGroup = $dbGroup->Fetch()) {
        $permissions[$arGroup["ID"]] = 'W';
    }

    \Bitrix\Catalog\Product\Sku::disableUpdateAvailable();
    $IBLOCK_CATALOG_ID = WizardServices::ImportIBlockFromXML(
        $iblockXMLFile,
        "clothes",
        $iblockType,
        WIZARD_SITE_ID,
        $permissions
    );
    $IBLOCK_CATALOG_ID1 = WizardServices::ImportIBlockFromXML(
        $iblockXMLFilePrices,
        "clothes",
        $iblockType . "_prices",
        WIZARD_SITE_ID,
        $permissions
    );
    \Bitrix\Catalog\Product\Sku::enableUpdateAvailable();
    if ($IBLOCK_CATALOG_ID < 1)
        return;

    $iblock = new CIBlock();
    $iblock->Update($IBLOCK_CATALOG_ID, array("LIST_MODE" => \Bitrix\Iblock\IblockTable::LIST_MODE_SEPARATE));

    $_SESSION["WIZARD_CATALOG_IBLOCK_ID"] = $IBLOCK_CATALOG_ID;
} else {
    $arSites = array();
    $db_res = CIBlock::GetSite($IBLOCK_CATALOG_ID);
    while ($res = $db_res->Fetch())
        $arSites[] = $res["LID"];
    if (!in_array(WIZARD_SITE_ID, $arSites)) {
        $arSites[] = WIZARD_SITE_ID;
        $iblock = new CIBlock();
        $iblock->Update($IBLOCK_CATALOG_ID, array("LID" => $arSites));
    }
}
