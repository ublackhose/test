<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

/**
 * @var CWizardBase $wizard
 */


if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$moduleId = 'redsign.vbasket';

/** @var CModule $obModule */
if ($obModule = \CModule::CreateModuleObject($moduleId)) {
    if ($obModule instanceof \CModule && !$obModule->IsInstalled()) {
        $obModule->DoInstall(false);
    }
}

if (Loader::includeModule($moduleId)) {
    $useOnSites = unserialize(Option::get($moduleId, 'use_on_sites'));

    if (!in_array(WIZARD_SITE_ID, $useOnSites)) {
        $useOnSites[] = WIZARD_SITE_ID;
        Option::set($moduleId, 'use_on_sites', serialize($useOnSites));
    }
}
