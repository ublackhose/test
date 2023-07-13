<?php

include($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$documentId = (int) $request->getQuery('id');

global $APPLICATION;
$APPLICATION->IncludeComponent(
	'redsign:b2bportal.documents.generator',
	'',
	[
		'DOCUMENT_ID' => $documentId
	]
);
