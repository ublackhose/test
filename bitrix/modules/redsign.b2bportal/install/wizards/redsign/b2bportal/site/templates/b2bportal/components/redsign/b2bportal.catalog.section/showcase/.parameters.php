<?php

use Bitrix\Main\Loader;
use Redsign\B2BPortal\ParametersUtils;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (Loader::includeModule('redsign.b2bportal'))
{
    ParametersUtils::addCommonParameters($arTemplateParameters, $arCurrentValues, array('sorter'));
}
