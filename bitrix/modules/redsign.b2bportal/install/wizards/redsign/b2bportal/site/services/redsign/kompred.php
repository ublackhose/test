<?php

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$moduleId = 'redsign.kompred';

/** @var CModule $obModule */
if ($obModule = \CModule::CreateModuleObject($moduleId)) {
    if ($obModule instanceof \CModule && !$obModule->IsInstalled()) {
        $obModule->DoInstall(false);
    }
}
