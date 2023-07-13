<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var SaleBasketLineComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


global $result;
$result = [];

switch($arParams['ACTION'])
{
	case 'getItems':
		foreach ($arResult['CATEGORIES'] as $category => $items)
		{
			if (empty($items))
				continue;

			$category = mb_strtolower($category);

			$result[$category] = [];
			foreach ($items as $item)
			{
				$rowData = [
					'id' => $item['ID'],
					'price' => $item['PRICE'],
					'priceGroup' => $item['NOTES'],
					'priceFmt' => $item['PRICE_FMT'],
					'sum' => $item['SUM_VALUE'],
					'sumFmt' => $item['SUM'],
					'quantity' => $item['QUANTITY'],
					'measure' => $item['MEASURE_NAME'],
					'name' => $item['NAME'],
					'pictureSrc' => $item['PICTURE_SRC'],
					'detailPageUrl' => $item['DETAIL_PAGE_URL'],
					'vendorCode' => ''
				];

				if ($arResult['ELEMENTS'][$item['PRODUCT_ID']])
				{
					$elementData = $arResult['ELEMENTS'][$item['PRODUCT_ID']];
					$articlePropertyCode = $arResult['ARTICLE_PROP_CODES'][$elementData['IBLOCK_ID']];
					if (isset($elementData['PROPERTY_' . $articlePropertyCode . '_VALUE']))
						$rowData['vendorCode'] = $elementData['PROPERTY_' . $articlePropertyCode . '_VALUE'];
				}

				$result[$category][] = $rowData;
			}
		}
		break;
}
