<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$arServices = array(
    'main' => array(
        'NAME' => GetMessage('SERVICE_MAIN_SETTINGS'),
        'STAGES' => array(
            'files.php', // Copy bitrix files
            'search.php', // Indexing files
            'template.php', // Install template
            'theme.php', // Install theme
            'menu.php', // Install menu
            'settings.php',
        ),
    ),
    'catalog' => array(
        'NAME' => GetMessage('SERVICE_CATALOG_SETTINGS'),
        'STAGES' => array(
            'index.php'
        ),
    ),
    'iblock' => array(
        'NAME' => GetMessage('SERVICE_IBLOCK_DEMO_DATA'),
        'STAGES' => array(
            'types.php', //IBlock types
            'news.php',
            'action.php',
            'docs.php',
            'managers.php',
            'references.php',//reference of colors
            'references2.php',
            'catalog.php', //catalog iblock import
            'catalog2.php', //offers iblock import
            'catalog3.php',
            'banners_banners_grid.php',
        ),
    ),
    'sale' => array(
        'NAME' => GetMessage('SERVICE_SALE_DEMO_DATA'),
        'STAGES' => array(
            'locations.php',
            'step1.php',
            'step2.php',
            'step3.php'
        ),
    ),
    'redsign' => array(
        'NAME' => GetMessage('SERVICE_REDSIGN'),
        'STAGES' => array(
            'devfunc.php',
            'vbasket.php',
            'settings.php',
            'tuning.php',
            'kompred.php'
        ),
        'MODULE_ID' => 'redsign.b2bportal'
    ),
);
