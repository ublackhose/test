<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


$isModuleCurrencyInstalled = Loader::includeModule('currency');

Loc::loadMessages(__DIR__ . '/template.php');



if (!isset($arResult['ERRORS']['FATAL']))
{
    $columns = [];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_ACCOUNT_NUMBER'),
        'field' => 'ID',
        'sortable' => true,
        'html' => false,
    ];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_DATE_INSERT'),
        'field' => 'DATE_INSERT',
        'sortable' => true,
        'html' => false,
    ];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_STATUS'),
        'field' => 'STATUS_ID',
        'sortable' => true,
        'html' => false,
    ];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_PRICE'),
        'field' => 'PRICE',
        'sortable' => true,
        'html' => false,
    ];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_PAYMENT'),
        'field' => 'PAYED',
        'sortable' => true,
        'html' => false,
    ];
    $columns[] = [
        'label' => Loc::getMessage('RS_B2BPORTAL_SPOL_COLUMN_SHIPMENT'),
        'field' => 'shipment',
        'sortable' => false,
        'html' => false,
    ];
    $columns[] = [
        'label' => '',
        'field' => 'actions',
        'sortable' => false,
        'html' => false,
    ];

    $statusIds = [];
    if (isset($arResult['INFO']['STATUS']))
    {
        foreach($arResult['INFO']['STATUS'] as $statusId => $status)
        {
            $statusIds[] = $statusId;
        }
        unset($statusId, $status);
    }

    $statuses = [];
    if (count($statusIds) > 0)
    {
        $statusIterator = \Bitrix\Sale\Internals\StatusLangTable::getList(array(
            'order' => array('STATUS.SORT' => 'ASC'),
            'filter' => array('STATUS.ID' => $statusIds,'LID' => LANGUAGE_ID),
            'select' => array('STATUS_ID', 'STATUS_COLOR' => 'STATUS.COLOR', 'NAME', 'DESCRIPTION'),
        ));

        while ($status = $statusIterator->fetch())
        {
            $statuses[$status['STATUS_ID']] = [
                'name' => $status['NAME'],
                'color' => $status['STATUS_COLOR'],
                'description' => $status['DESCRIPTION']
            ];
        }
        unset($status, $statusIds);
    }

    $rows = [];
    foreach($arResult['ORDERS'] as $order)
    {
        $orderData = $order['ORDER'];
        $orderShipments = $order['SHIPMENT'] ?? [];
        $items = $order['BASKET_ITEMS'] ?? [];

        $rowData = [
            'dateInsert' => $orderData['DATE_INSERT_FORMATED'],
            // 'dateUpdate' => $order['DATE_UPDATE_FORMATED'],
            'accountNumber' => $orderData['ACCOUNT_NUMBER'],
            'statusId' => $orderData['STATUS_ID'],
            'status' => isset($statuses[$orderData['STATUS_ID']]) ? $statuses[$orderData['STATUS_ID']] : '',
            'price' => $orderData['PRICE'],
            'formatedPrice' => $orderData['FORMATED_PRICE'],
            'payed' => $orderData['PAYED'] === 'Y',
            'datePayed' => $orderData['PAYED'] === 'Y' ? (string) $orderData['DATE_PAYED'] : '',
            'canceled' => $orderData['CANCELED'] === 'Y',
            'dateCanceled' => $orderData['CANCELED'] === 'Y' ? $orderData['DATE_CANCELED_FORMATED'] : '',
            'shipments' => [],
            'items' => [],
            'urlToDetail' => $orderData['URL_TO_DETAIL'],
            'urlToCopy' => $orderData['URL_TO_COPY'],
            'urlToCancel' => $orderData['URL_TO_CANCEL'],
            'urlToUpdate' => "/personal/orders/".$orderData['ID']."/?update=Y",
        ];

        foreach ($items as $item)
        {
            $itemData = [
                'id' => $item['ID'],
                'name' => $item['NAME'],
                'detailPageUrl' => $item['DETAIL_PAGE_URL'],
                'quantity' => $item['QUANTITY'],
                'price' => $item['PRICE'],
                'sum' => $item['PRICE'] * $item['QUANTITY'],
            ];

            if ($isModuleCurrencyInstalled)
            {
                $itemData['currency'] = $item['CURRENCY'];
                $itemData['priceFormatted'] = \CCurrencyLang::CurrencyFormat($itemData['price'], $itemData['currency']);
                $itemData['sumFormatted'] = \CCurrencyLang::CurrencyFormat($itemData['sum'], $itemData['currency']);
            }
            else
            {
                $itemData['priceFormatted'] = $itemData['price'];
                $itemData['sumFormatted'] = $itemData['sum'];
            }

            $rowData['items'][] = $itemData;
        }
        unset($itemData);

        if (is_array($orderShipments) && count($orderShipments) > 0)
        {
            foreach($orderShipments as $shipment)
            {
                $rowData['shipments'][] = [
                    'statusId' => $shipment['STATUS_ID'],
                    'deliveryName' => $shipment['DELIVERY_NAME'],
                    'deliveryStatusName' => $shipment['DELIVERY_STATUS_NAME'],
                    'deducted' => $shipment['DEDUCTED'] === 'Y',
                    'dateDeducted' => $shipment['DEDUCTED'] === 'Y' ? (string) $shipment['DATE_DEDUCTED'] : ''
                ];
            }
        }

        $rows[] = $rowData;
    }
    unset($orderData, $items, $orderShipments);

    if ($arParams['NAV_TEMPLATE'] === 'json')
    {
        $arResult['NAV_OPTIONS'] = \Bitrix\Main\Web\Json::decode($arResult['NAV_STRING']);
    }
    else
    {
        $arResult['NAV_OPTIONS'] = [];
    }

    $arResult['SORT_OPTIONS'] = [
        'field' => $arResult['SORT_TYPE'],
        'type' => isset($_REQUEST['order']) ? strtolower(htmlspecialcharsbx($_REQUEST['order'])) : 'asc'
    ];

    $arResult['STATUSES'] = $statuses;
    $arResult['COLUMNS'] = $columns;
    $arResult['ROWS'] = $rows;

    unset($columns, $rows, $statuses);
}



if($_REQUEST['filter_user']){
    $arResult['NAV_OPTIONS']['perPage'] = 100;
}
