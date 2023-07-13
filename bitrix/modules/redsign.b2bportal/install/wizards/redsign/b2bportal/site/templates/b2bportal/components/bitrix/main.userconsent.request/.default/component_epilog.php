<?php

/**
 * @var CMain $APPLICATION
 * @var MainUserConsentRequestComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


\CJSCore::RegisterExt(
    'main_user_consent',
    [
        'js' => $templateFolder . '/user_consent.js',
        'css' => $templateFolder . '/user_consent.css',
        'lang' => $templateFolder . '/user_consent.php',
        'rel' => []
    ]
);

\CJSCore::Init(['popup', 'ajax', 'main_user_consent']);
