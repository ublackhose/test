<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\ParametersUtils;

/**
 * @var array $arTemplateParameters
 * @var array $arCurrentValues
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


if (!Loader::includeModule('redsign.devfunc'))
{
    return;
}
if (!Loader::includeModule('redsign.b2bportal'))
{
    return;
}

// $arResetParams = array(
//     'USE_SEARCH',

//     'USE_RSS',

//     'USE_RATING',

//     'USE_CATEGORIES',

//     'USE_REVIEW',

//     'USE_FILTER',

//     'USE_FILTER',

//     'DISPLAY_PICTURE',
//     'DISPLAY_PREVIEW_TEXT',
//     'USE_SHARE',

//     'HIDE_LINK_WHEN_NO_DETAIL',

//     'DISPLAY_NAME',
// );

// foreach ($arResetParams as $key)
// {
//     $arTemplateParameters[$key] = array(
//         'TYPE' => 'CUSTOM',
//         'JS_FILE' => ParametersUtils::getSettingsScript('reset_param'),
//         'JS_EVENT' => 'initRSB2BPortalResetParam',
//     );
// }


ParametersUtils::addCommonParameters($arTemplateParameters, $arCurrentValues, array('sorter'));

$arTemplateParameters['TEMPLATE_URL_OWNER_ID'] = [
    'NAME' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.TEMPLATE_URL_OWNER_ID'),
    'TYPE' => 'STRING',
    'DEFAULT' => '',
    'REFRESH' => 'N',
];

$arTemplateParameters['TEMPLATE_URL_ORDER_ID'] = [
    'NAME' => Loc::getMessage('RS.B2BPORTAL.NEWS_LIST.TEMPLATE_URL_ORDER_ID'),
    'TYPE' => 'STRING',
    'DEFAULT' => '',
    'REFRESH' => 'N',
];
