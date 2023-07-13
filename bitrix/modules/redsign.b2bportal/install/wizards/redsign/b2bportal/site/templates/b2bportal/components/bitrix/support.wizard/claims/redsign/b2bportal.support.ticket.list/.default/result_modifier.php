<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__DIR__ . '/template.php');

$arResult['PREPARED_COLUMNS'] = [
    [
        'label' => '',
        'field' => 's_lamp',
        'sortable' => false,
        'html' => true,
        'thClass' => 'stl-indicator-cell',
        'tdClass' => 'stl-indicator-cell',
        // 'width' => '130px'
    ],
    [
        'label' => Loc::getMessage('SUP_ID'),
        'field' => 's_id',
        'sortable' => true,
        'html' => false,
        'thClass' => 'stl-id-cell',
        'tdClass' => 'stl-id-cell',
    ],
    [
        'label' => Loc::getMessage('SUP_TITLE'),
        'field' => 's_title',
        'sortable' => false,
        'html' => false,
        'thClass' => 'stl-title-cell',
        'tdClass' => 'stl-title-cell',
    ],
    [
        'label' => Loc::getMessage('SUP_TIMESTAMP'),
        'field' => 's_timestamp_x',
        'sortable' => true,
        'html' => false,
        'thClass' => 'stl-timestamp-x-cell',
        'tdClass' => 'stl-timestamp-x-cell',
        //'width' => '200px'
    ],
    // [
    //  'label' => Loc::getMessage('SUP_MESSAGES'),
    //  'field' => 's_messages',
    //  'sortable' => false,
    //  'html' => false,
    //  //'width' => '120px'
    // ],
    [
        'label' => Loc::getMessage('SUP_STATUS'),
        'field' => 's_status_name',
        'sortable' => false,
        'html' => false,
        'tdClass' => 'stl-status-cell',
        'thClass' => 'stl-status-cell',
        //'width' => '120px'
    ],
];

if (is_array($arResult['ROWS']) && count($arResult['ROWS']) > 0)
{
    $arResult['PREPARED_ROWS'] = array_map(function ($row) {
        return [
            'url' => $row['data']['TICKET_EDIT_URL'] ?? '',
            'created' => $row['data']['DATE_CREATE'] ?? '',
            's_lamp' => $row['columns']['LAMP'] ?? '',
            's_id' => $row['data']['ID'] ?? null,
            's_title' => $row['data']['TITLE'] ?? '',
            's_timestamp_x' => $row['data']['TIMESTAMP_X'] ?? '',
            's_messages' => $row['data']['MESSAGES'] ?? 0,
            's_status_name' => $row['data']['STATUS_NAME'] ?? ''
        ];
    }, $arResult['ROWS']);
}
else
{
    $arResult['PREPARED_ROWS'] = [];
}
// $arResult['PREPARED_ROWS'] = [];

if (isset($arResult['NAV_OBJECT']))
{
    $arResult['PREPARED_PAGINATION'] = $pagination = [
        'perPage' => (int) $arParams['TICKETS_PER_PAGE'],
        'navName' => 'PAGEN_' . $arResult['NAV_OBJECT']->NavNum,
        'currentPage' => (int) $arResult['NAV_OBJECT']->NavPageNomer,
        'totalRecords' => (int) $arResult['NAV_OBJECT']->NavRecordCount,
    ];
}
else
{
    $arResult['PREPARED_PAGINATION'] = [];
}

$sortOptions = $arResult['SORT'];
reset($sortOptions);

$arResult['PREPARED_SORT_OPTIONS'] = [
    'field' => key($sortOptions),
    'type' => current($sortOptions)
];

$this->__component->SetResultCacheKeys([
    'PREPARED_COLUMNS', 'PREPARED_ROWS', 'PREPARED_PAGINATION'
]);
