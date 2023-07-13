<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Localization\Loc;

$jsonResult = [
	'messages' => [],
];

if (!empty($arResult["errorMessage"]))
{
	$jsonResult['messages'][] = [
		'text' => is_array($arResult["errorMessage"]) ? implode('<br>', $arResult["errorMessage"]) : $arResult["errorMessage"],
		'type' => 'error'
	];
}
else
{
	if ($arResult['IS_ALLOW_PAY'] == 'N')
	{
		$jsonResult['messages'][] = [
			'text' => Loc::getMessage('SOPC_PAY_SYSTEM_CHANGED').' <br>'.Loc::getMessage("SOPC_PAY_SYSTEM_NOT_ALLOW_PAY"),
			'type' => 'info'
		];
	}
	elseif ($arResult['SHOW_INNER_TEMPLATE'] == 'Y')
	{
		if ($arParams['ONLY_INNER_FULL'] === 'Y' && $arResult['INNER_PAYMENT_INFO']['CURRENT_BUDGET'] < $arResult['PAYMENT']["SUM"])
		{
			$jsonResult['messages'][] = [
				'text' => Loc::getMessage('SOPC_LOW_BALANCE'),
				'type' => 'error'
			];
		}
		else
		{
			$jsonResult['isInnerPayment'] = true;
			$jsonResult['isOnlyInnerFull'] = $arParams['ONLY_INNER_FULL'] === 'Y';
			$jsonResult['innerPaymentData'] = [
				'budget' => $arResult['INNER_PAYMENT_INFO']['CURRENT_BUDGET'],
				'budgetFormatted' => SaleFormatCurrency($arResult['INNER_PAYMENT_INFO']['CURRENT_BUDGET'], $arResult['INNER_PAYMENT_INFO']["CURRENCY"]),
				'sum' =>  $arResult['PAYMENT']["SUM"],
				'sumFormatted' => SaleFormatCurrency($arResult['PAYMENT']["SUM"], $arResult['PAYMENT']["CURRENCY"])
			];
		}
	}
	elseif (empty($arResult['PAYMENT_LINK']) && !$arResult['IS_CASH'] && strlen($arResult['TEMPLATE']))
	{
		$jsonResult['messages'][] = [
			'text' => Loc::getMessage('SOPC_PAY_SYSTEM_CHANGED'),
			'type' => 'success'
		];
	}
	else
	{
		$jsonResult['messages'][] = [
			'text' => Loc::getMessage('SOPC_PAY_SYSTEM_CHANGED'),
			'type' => 'success'
		];
		
		if (!$arResult['IS_CASH'] && strlen($arResult['PAYMENT_LINK']))
		{
			$jsonResult['paymentLink'] = $arResult['PAYMENT_LINK'];
		}
	}
}

echo \Bitrix\Main\Web\Json::encode($jsonResult);