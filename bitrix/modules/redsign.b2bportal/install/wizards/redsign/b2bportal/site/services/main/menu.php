<?php

/**
 * @var CWizardBase $wizard
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


CModule::IncludeModule('fileman');
$arMenuTypes = GetMenuTypes(WIZARD_SITE_ID);

$arMenuTypes['aside'] = GetMessage("WIZ_MENU_ASIDE");
$arMenuTypes['footer'] = GetMessage("WIZ_MENU_FOOTER");

SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);
COption::SetOptionInt("fileman", "num_menu_param", 2, false, WIZARD_SITE_ID);
