<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\DI;

/**
 * @var CMain $APPLICATION
 * @var RSB2BPortalCatalogSectionComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


/** @var \Bitrix\Main\HttpRequest */
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
{
	if (isset($arParams['~RELATIVE_QUANTITY_FACTOR']) && 0 >= $arParams['~RELATIVE_QUANTITY_FACTOR'])
		$arParams['RELATIVE_QUANTITY_FACTOR'] = 0;

	if (empty($arParams['MESS_RELATIVE_QUANTITY_MANY']))
		$arParams['MESS_RELATIVE_QUANTITY_MANY'] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_RELATIVE_QUANTITY_MANY');

	if (empty($arParams['MESS_RELATIVE_QUANTITY_FEW']))
		$arParams['MESS_RELATIVE_QUANTITY_FEW'] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_RELATIVE_QUANTITY_FEW');

	if (empty($arParams['MESS_RELATIVE_QUANTITY_NO']))
		$arParams['MESS_RELATIVE_QUANTITY_NO'] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_RELATIVE_QUANTITY_NO');
}

/** @var string */
$type = $request->getQuery($arParams['EXPORT_ACTION_VARIABLE']);
if (!$type || !in_array($type, ['csv', 'ods', 'xlsx']))
	$type = 'xlsx';

$APPLICATION->RestartBuffer();
if ($templateData['ITEMS_ROWS'])
{
	$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();
	$container = DI\ServiceContainer::getInstance();
	/** @var \Redsign\B2BPortal\Spreadsheet\PhpSpreadsheetWriter $writer */
	$writer = $container->get('Spreadsheet\Writer');

	$catalogGroups = [];
	if ($arParams['PRICE_CODE'])
	{
		$groupIterator = CCatalogGroup::GetList(
			array("SORT" => "ASC"),
			array("=NAME" => $arParams['PRICE_CODE'])
		);
		while($catalogGroup = $groupIterator->GetNext())
		{
			if ($catalogGroup['CAN_ACCESS'] === 'Y')
				$catalogGroups[] = $catalogGroup;
		}

		unset($groupIterator, $catalogGroup);
	}

	$headingRow = [];
	$headingRow[] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_HEADER_NAME');
	$headingRow[] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_HEADER_ARTICLE');
	if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
		$headingRow[] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_HEADER_AVAILABLE');
	$headingRow[] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_HEADER_UNIT');
	foreach ($catalogGroups as $catalogGroup)
		$headingRow[] = $catalogGroup['NAME_LANG'];
	$headingRow[] = Loc::getMessage('RS_B2B_CS_SPREADSHEET_HEADER_QUANTITY');

	$writer->addRow($headingRow, [
		'autoSize' => true,
		'style' => [
			'font' => [
				'bold' => true
			]
		]
	]);
	unset($headingRow);

	foreach ($templateData['ITEMS_ROWS'] as $itemRow)
	{
		if (empty($itemRow['products'])) continue;

		foreach ($itemRow['products'] as $product)
		{
			$rowData = [];

			$name = $product['name'] ?? $itemRow['name'];
			$url = $host . $itemRow['url'];

			$rowData[] = [$name, ['url' => $url]];
			$rowData[] = (!empty($product['vendorCode'])) ? $product['vendorCode'] : $itemRow['vendorCode'];

			if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
			{
				if ($product['inStock'] >= $arParams['RELATIVE_QUANTITY_FACTOR'])
				{
					$rowData[] = $arParams['MESS_RELATIVE_QUANTITY_MANY'];
				}
				elseif($product['inStock'] > 0)
				{
					$rowData[] = $arParams['MESS_RELATIVE_QUANTITY_FEW'];
				}
				else
				{
					$rowData[] = $arParams['MESS_RELATIVE_QUANTITY_NO'];
				}
			}
			elseif ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
			{
				$rowData[] = $product['inStock'];
			}

			$rowData[] = $product['measure'];

			$prices = reset($product['prices']);
			foreach ($catalogGroups as $catalogGroup)
				$rowData[] = $prices['catalog_price_scale_' . $catalogGroup['ID']];

			$rowData[] = $product['ratio'];

			$writer->addRow($rowData);
		}
		unset($rowData, $product);
	}
	unset($itemRow);

	if (isset($arResult['NAME']))
	{
		$filename = \CUtil::translit($arResult['NAME'], 'ru') . '.' . $type;
	}
	else
	{
		$filename = 'catalog.' . $type;
	}

	$writer->openToBrowser($filename);
}
else
{
	echo '<span style="color: red">' . Loc::getMessage('RS_B2B_CS_SPREADSHEET_ITEMS_NOT_FOUND') . '</span>';
}
\CMain::FinalActions();
die();
