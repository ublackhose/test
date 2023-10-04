<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
if ($request->getQuery('export') && in_array($request->getQuery('export'), ['csv', 'ods', 'xlsx', 'xls']) && $request->getQuery('order')) {

    include_once $_SERVER['DOCUMENT_ROOT'] .'/exe/export/spreadsheet.php';
    return;
}

if ($request->getQuery('export') && in_array($request->getQuery('export'), ['csv', 'ods', 'xlsx', 'xls']) && $request->getQuery('orders')) {
    include_once $_SERVER['DOCUMENT_ROOT'] .'/exe/export/export_graph.php';
    return;
}