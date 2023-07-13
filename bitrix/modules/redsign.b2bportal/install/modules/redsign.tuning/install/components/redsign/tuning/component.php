<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\SystemException;
use Redsign\Tuning;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


global $APPLICATION;

Loc::loadMessages(__FILE__);

if (!Loader::includeModule('redsign.tuning') || rsTuningIsHideTuning())
    return;

$fromSession = Option::get('redsign.tuning', 'fromSession', '', SITE_ID);

try {
    if (!Loader::includeModule('redsign.devfunc'))
        throw new SystemException('Not included module redsign.devfunc');

    $asset = Asset::getInstance();

    \CJSCore::Init([
        'rs_color',
        'redsign.tuning'
    ]);

    $tuning = Tuning\TuningCore::getInstance();

    if (!$tuning)
        throw new SystemException('Tuning options error');

    $instanceOptionManager = Tuning\OptionManager::getInstance();
    $instanceTab = Tuning\TabCore::getInstance();
    $instanceOption = Tuning\TuningOption::getInstance();
    $instanceCssFileManager = Tuning\CssFileManager::getInstance();
    $instanceMacrosManager = Tuning\MacrosManager::getInstance($tuning);

    $asset->addCss($instanceCssFileManager->getFileColorCompiled(), true);

    if ($fromSession != 'Y' && !$USER->IsAdmin())
        return;

    $asset->addString('<link href="https://fonts.googleapis.com/css?tuning=yes&amp;family=Montserrat:400,500&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">');

    $asset->addCss($arParams['CUSTOM_CSS'], true);
    $asset->addJs($arParams['CUSTOM_JS']);

    $optionList = $instanceOptionManager->getOptions();

    $arResult['FROM_SESSION'] = $fromSession == 'Y' ? 'Y' : 'N';
    $arResult['COOKIE_OPEN'] = $APPLICATION->get_cookie('COOKIE_OPEN', 'RSTUNING') == 'Y' ? 'Y' : 'N';
    $tabActiveFromCookie = $APPLICATION->get_cookie('COOKIE_TAB_ACTIVE', 'RSTUNING');
    $arResult['FORM_ACTION'] = $componentPath . '/ajax.php';
    $arResult['FILE_COLOR_MACROS_CONTENT'] = $instanceCssFileManager->getFileColorMacrosContent();
    $arResult['FILE_COLOR_COMPILED_CONTENT'] = $instanceCssFileManager->getFileColorCompiledContent($instanceMacrosManager->getReadyMacros());
    $arResult['OPTIONS'] = [];
    $arResult['TABS'] = [];
    $arResult['TABS']['ITEMS'] = $instanceTab->getTabList();

    if (!empty($arResult['TABS']['ITEMS'])) {
        if (array_key_exists($tabActiveFromCookie, $arResult['TABS']['ITEMS'])) {
            $arResult['TABS']['FIRST_TAB_ID'] = $tabActiveFromCookie;
        } else {
            reset($arResult['TABS']['ITEMS']);
            $arResult['TABS']['FIRST_TAB_ID'] = key($arResult['TABS']['ITEMS']);
        }
    } else {
        $arResult['TABS'] = [];
    }

    foreach ($optionList as $id => $arOption) {
        $optionObj = $instanceOption->getOptionObjectByName($arOption['TYPE']);
        if ($optionObj != null) {
            $arOption['ID'] = $id;

            $optionObj->onload();

            if ($instanceOptionManager->isChildrenById($id))
                continue;

            $arOption['VALUE'] = $tuning->getOptionValue($id);

            ob_start();
            $optionObj->showOption($arOption);
            $out = ob_get_contents();
            ob_end_clean();

            $arResult['OPTIONS'][$id] = $arOption;
            $arResult['OPTIONS'][$id]['DISPLAY_HTML'] = $out;

            if (!empty($arResult['TABS']['ITEMS'])) {
                if (!empty($arOption['TAB'])) {
                    $arResult['TABS']['ITEMS'][$arOption['TAB']]['OPTIONS'][] = $id;
                } else {
                    $arResult['TABS']['ITEMS'][$arResult['TABS']['FIRST_TAB_ID']]['OPTIONS'][] = $id;
                }
            }
        }
    }

    if ($fromSession == 'Y') {
        $asset->addString('<style>' . $arResult['FILE_COLOR_COMPILED_CONTENT'] . '</style>');
    }

    $this->IncludeComponentTemplate();
} catch (\Throwable $ex) {
}
