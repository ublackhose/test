<?php

use Bitrix\Main\Config\Option;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


global $APPLICATION;

$statusIterator = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
    'order' => array('STATUS.SORT' => 'ASC'),
    'filter' => array('STATUS.ID' => $arResult['STATUS_ID'] ?? 'N', 'LID' => LANGUAGE_ID),
    'select' => array('STATUS_ID', 'STATUS_COLOR' => 'STATUS.COLOR', 'NAME', 'DESCRIPTION'),
));

$status = $statusIterator->fetch();

if ($status)
{
    $arResult['STATUS'] = [
        'ID' => $status['STATUS_ID'],
        'NAME' => $status['NAME'],
        'COLOR' => $status['STATUS_COLOR']
    ];
}

$arResult['ORDER_PROPS_GROUPS'] = [];
if (isset($arResult['ORDER_PROPS']) && is_array($arResult['ORDER_PROPS']))
{
    foreach($arResult['ORDER_PROPS'] as $prop)
    {
        if (!isset($arResult['ORDER_PROPS_GROUPS'][$prop['PROPS_GROUP_ID']]))
        {
            $arResult['ORDER_PROPS_GROUPS'][$prop['PROPS_GROUP_ID']] = [
                'NAME' => $prop['GROUP_NAME'],
                'SORT' => (int) $prop['SORT'],
                'PROPS' => []
            ];
        }

        $arResult['ORDER_PROPS_GROUPS'][$prop['PROPS_GROUP_ID']]['PROPS'][] = $prop;
    }
}

$arResult['DOCUMENTS'] = [];
if (\Bitrix\Main\Loader::includeModule('iblock'))
{
    $rsDocuments = CIBlockElement::GetList(
        ['SORT' => 'ASC'],
        [
            'IBLOCK_ID' => $arParams['DOCUMENTS_IBLOCK_ID'],
            'PROPERTY_ORDER_ID' => $arResult['ID'],
            'PROPERTY_OWNER_ID' => $arResult['USER_ID']
        ],
        false,
        false,
        ['ID', 'ACTIVE_FROM', 'NAME', 'SORT', 'PROPERTY_FILE', 'PROPERTY_TYPE', 'PROPERTY_GEN_TYPE']
    );

    $genDocsPath = Option::get('redsign.b2bportal', 'generate_docs_path', '', SITE_ID);

    $documents = [];
    $typeValues = [];

    while ($document = $rsDocuments->GetNext())
    {
        if (!empty($document['PROPERTY_GEN_TYPE_VALUE']))
        {
            $filePath = CComponentEngine::MakePathFromTemplate($genDocsPath, [
                'SITE_DIR' => SITE_DIR,
                'DOCUMENT_ID' => $document['ID']
            ]);
        }
        else
        {
            $filePath = CFile::GetPath($document['PROPERTY_FILE_VALUE']);
        }

        $documents[] = [
            'DATE' => $document['ACTIVE_FROM'] ?? '',
            'ID' => $document['ID'],
            'NAME' => $document['NAME'],
            'TYPE' => $document['PROPERTY_TYPE_ENUM_ID'],
            'FILE_PATH' => $filePath
        ];
    }
    unset($document, $rsDocument);

    if (count($documents) > 0)
    {
        $typeIds = array_unique(array_map(function ($document) {
            return $document['TYPE'];
        }, $documents));

        $typeValues = array_fill_keys(
            $typeIds,
            []
        );

        $rsTypeValues = CIBlockPropertyEnum::GetList(
            [],
            [
                'ID' => $typeIds,
                'CODE' => 'TYPE',
                'IBLOCK_ID' => $arParams['DOCUMENTS_IBLOCK_ID'],
            ]
        );

        while($value = $rsTypeValues->GetNext())
        {
            $typeValues[$value['ID']] = $value;
        }
        unset($value, $rsTypeValues, $typeIds);

        foreach ($documents as &$document)
        {
            $document['TYPE'] = $typeValues[$document['TYPE']];
        }
        unset($document, $typeValues);
    }

    $arResult['DOCUMENTS'] = $documents;
    unset($documents);
}

$arResult['TICKETS'] = [];

if (\Bitrix\Main\Loader::includeModule('support') && $APPLICATION->GetGroupRight('support') >= 'R')
{
    $sortBy = 's_id';
    $sortOrder = 'desc';
    $isFiltered = 'N';

    $rsTickets = CTicket::GetList(
        $sortBy,
        $sortOrder,
        ['UF_ORDER_ID' => $arResult['ID']],
        $isFiltered,
        'Y',
        'N',
        'N',
        false,
        [
            'SELECT' => ['UF_ORDER_ID'],
            'NAV_PARAMS' => ['nPageSize' => 10, 'bShowAll' => false]
        ]
    );

    while ($ticket = $rsTickets->GetNext())
    {
        $ticket['TICKET_EDIT_URL'] = CComponentEngine::MakePathFromTemplate(
            $arParams["CLAIM_DETAIL"],
            ["ID" => $ticket["ID"]]
        );

        $arResult['TICKETS'][] = $ticket;
    }

    unset($sortBy, $sortOrder, $arFilter, $ticket);

    $arResult['ADD_TICKET'] = CComponentEngine::makePathFromTemplate(
        $arParams['ADD_CLAIM_PATH'],
        array(
            'ORDER_NUMBER' => urlencode(urlencode($arResult['ACCOUNT_NUMBER']))
        )
    );



    $arResult['TICKET_LIST'] = CComponentEngine::makePathFromTemplate(
        $arParams['CLAIMS_PATH'],
        array(
            'ORDER_NUMBER' => urlencode(urlencode($arResult['ACCOUNT_NUMBER']))
        )
    );
}

$arResult['ORDER_CHANGE_HISTORY'] = [];

$nav = new \Bitrix\Main\UI\PageNavigation("order-history");
$nav->allowAllRecords(true)
   ->setPageSize(10)
   ->initFromUri();

$historyIterator = Bitrix\Sale\Internals\OrderChangeTable::getList([
    'order' => ['DATE_CREATE' => 'DESC'],
    'filter' => ['ORDER_ID' => $arResult['ID']],
    "count_total" => true,
    "offset" => $nav->getOffset(),
    "limit" => $nav->getLimit(),
]);

$nav->setRecordCount($historyIterator->getCount());

while ($historyRecord = $historyIterator->fetch())
{
    $historyData = CSaleOrderChange::GetRecordDescription($historyRecord["TYPE"], $historyRecord["DATA"]);

    $arResult['ORDER_CHANGE_HISTORY'][] = [
        'DATE_CREATE' => $historyRecord['DATE_CREATE']->toString(),
        'NAME' => $historyData['NAME'],
        'INFO' => $historyData['INFO']
    ];
}

$arResult['ORDER_CHANGE_HISTORY_NAV'] = $nav;

/** @var \Redsign\B2BPortal\Services\UserSettings $userSettings */
$userSettings = \Redsign\B2BPortal\DI\ServiceContainer::getInstance()->get('Services\UserSettings');

$orderPropsBlocks = array_map(function ($prop) {
    return 'order_group_' . $prop;
}, array_keys($arResult['ORDER_PROPS_GROUPS']));

$defaultBlockSort = [
    [
        'list',
        'payment',
        'shipment',
        'order_history'
    ],
    array_merge(
        ['user_info'],
        $orderPropsBlocks,
        ['documents', 'tickets']
    )
];

$columns = 2;

/** @var array|null $savedBlockSort */
$savedBlockSort = $userSettings->get('sod_sorted_blocks');
if (is_array($savedBlockSort) && count($savedBlockSort) !== 0)
{
    $allBlocks = array_merge(['list', 'payment', 'shipment', 'order_history', 'user_info', 'documents', 'tickets'], $orderPropsBlocks);
    $blockSort = array_fill(0, $columns, []);

    for ($i = 0; $i < $columns; $i++)
    {
        $blockSort[$i] = $savedBlockSort[$i] ?? $blockSort[$i];
    }

    $allSortedBlocks = call_user_func_array('array_merge', $blockSort);
    $forgottenBlocks = array_values(array_diff($allBlocks, $allSortedBlocks));

    foreach ($forgottenBlocks as $forgottenBlock)
    {
        $isFind = false;
        foreach ($defaultBlockSort as $column => $columnBlocks)
        {
            if (in_array($forgottenBlock, $columnBlocks))
            {
                $isFind = true;
                $blockSort[$column][] = $forgottenBlock;
                break;
            }
        }

        if (!$isFind)
        {
            $blockSort[0][] = $forgottenBlock;
        }
    }

    unset(
        $allBlocks,
        $isFind,
        $allSortedBlocks,
        $forgottenBlocks,
        $columnBlocks,
        $forgottenBlock
    );
}
else
{
    $blockSort = $defaultBlockSort;
    $userSettings->set('sod_sorted_blocks', $blockSort);
}

$collapsedBlocks = $userSettings->get('sod_collapsed_blocks');
if (!$collapsedBlocks)
{
    $collapsedBlocks = [];
}

$arResult['SORTED_BLOCKS'] = $blockSort;
$arResult['COLLAPSED_BLOCKS'] = $collapsedBlocks;
unset(
    $savedBlockSort,
    $blockSort,
    $collapsedBlocks,
    $userSettings
);
