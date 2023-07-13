<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$componentPage = 'list';

$arDefaultTemplates404 = [
    'list' => '/',
    'create' => 'create/',
    'edit' => 'edit/#ID#/',
    'download' => 'download/#CODE#/',
];

$arDefaultVariableAliases404 = [];

$arDefaultVariableAliases = [];

$arComponentVariables = [
    'ID',
    'CODE',
    'ACTION'
];

if ($arParams['SEF_MODE'] == 'Y')
{
    $arVariables = [];

    $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
        $arDefaultTemplates404,
        $arParams['SEF_URL_TEMPLATES']
    );

    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
        $arDefaultVariableAliases404,
        $arParams['VARIABLE_ALIASES']
    );

    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams['SEF_FOLDER'],
        $arUrlTemplates,
        $arVariables
    );

    if (!$componentPage)
        $componentPage = 'list';

    $arResult = array(
        'FOLDER' => $arParams['SEF_FOLDER'],
        'URL_TEMPLATES' => $arUrlTemplates,
        'VARIABLES' => $arVariables,
        'ALIASES' => $arVariableAliases
    );
}
else
{
    $arVariables = [];

    $arVariableAliases = CComponentEngine::makeComponentVariableAliases(
        $arDefaultVariableAliases,
        $arParams["VARIABLE_ALIASES"]
    );

    CComponentEngine::initComponentVariables(
        '',
        $arComponentVariables,
        $arVariableAliases,
        $arVariables
    );

    $componentPage = $arVariables['ACTION'] ?? 'list';
    if (!in_array($componentPage, ['create', 'edit', 'download']))
    {
        $componentPage = 'list';
    }

    $currentPage = htmlspecialcharsbx($APPLICATION->GetCurPage()) . "?";

    $this->arResult = [
        'FOLDER' => '',
        'URL_TEMPLATES' => [
            'list' => $currentPage,
            'create' => $currentPage . 'ACTION=create',
            'edit' => $currentPage . 'ACTION=edit&ID=#ID#',
            'download' => $currentPage . 'ACTION=download&CODE=#CODE#',
        ],
        'VARIABLES' => $arVariables,
        'ALIASES' => $arVariableAliases
    ];
}

$this->IncludeComponentTemplate($componentPage);
