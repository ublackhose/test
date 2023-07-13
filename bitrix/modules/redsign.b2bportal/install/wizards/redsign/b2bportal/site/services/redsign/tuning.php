<?php

use Bitrix\Main\Config\Option;

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$moduleId = 'redsign.tuning';

/** @var CModule $obModule */
if ($obModule = \CModule::CreateModuleObject($moduleId)) {
    if ($obModule instanceof \CModule && !$obModule->IsInstalled()) {
        $obModule->DoInstall();
    }
}

if (\Bitrix\Main\ModuleManager::isModuleInstalled($moduleId)) {
    Option::set($moduleId, 'dirOptionsExt', WIZARD_SITE_DIR . 'include/tuning/options.ext.php', WIZARD_SITE_ID);
    Option::set($moduleId, 'fileColorCompiled', WIZARD_SITE_DIR . 'include/tuning/color.css', WIZARD_SITE_ID);
    Option::set($moduleId, 'fileColorMacros', WIZARD_SITE_DIR . 'include/tuning/color.macros', WIZARD_SITE_ID);
    Option::set($moduleId, 'fileOptions', WIZARD_SITE_DIR . 'include/tuning/options.php', WIZARD_SITE_ID);
}
