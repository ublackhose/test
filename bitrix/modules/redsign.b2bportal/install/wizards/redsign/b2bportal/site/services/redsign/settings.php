<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

Option::set('redsign.b2bportal', 'wizard_installed', 'Y', WIZARD_SITE_ID);

if (Loader::includeModule('redsign.b2bportal')) {
    $arData = [
        'mp_code' => ['redsign.b2bportal'],
    ];

    $ret = \Redsign\B2BPortal\Core::registerInstallation($arData);
}
