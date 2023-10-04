<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixPersonalOrderListComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();



function getOrdersByUser(){
    if (CModule::IncludeModule('sale'))
    {
        global $USER;
        $result = array();
        $arFilter = Array(
            "USER_ID" => $USER->GetID(),
            "DATE_CANCELED" => ""
        );

        $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
        while ($ar_sales = $db_sales->Fetch())
        {
            $result[] = $ar_sales;
        }

        return $result;
    }
}


function GetPropsOfOrder($order_id){
    $arrResult = array();
    $obBasket = \Bitrix\Sale\Basket::getList(array('filter' => array('ORDER_ID' => $order_id)));
    while($bItem = $obBasket->Fetch()){
        $arrResult[] = $bItem;
    }
    return $arrResult;
}

$result = getOrdersByUser();
$order = GetPropsOfOrder($result[0]['ID']);
//echo "<pre>";print_r($order);echo "</pre>";
$this->addExternalJS($templateFolder . '/js/component.js');

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $code => $error)
	{
		if ($code !== $component::E_NOT_AUTHORIZED)
		{
			?>
			<div class="alert alert-danger" role="alert">
				<div class="alert-icon"><i class="flaticon-danger"></i></div>
				<div class="alert-text"><?=$error?></div>
			</div>
			<?
		}
	}
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}
}
else
{
	if (!empty($arResult['ERRORS']['NONFATAL']))
	{
		foreach($arResult['ERRORS']['NONFATAL'] as $error)
		{
			?>
			<div class="alert alert-warning" role="alert">
				<div class="alert-icon"><i class="flaticon-warning"></i></div>
				<div class="alert-text"><?=$error?></div>
			</div>
			<?
		}
	}

	$blockId = 'orders_' . $this->randString(5);

	$portlet = new Portlet();
	$portlet->head(function () use ($APPLICATION) {
		?><div class="kt-portlet__head">
			<?php
			$clearParams = ["filter_history","filter_status","show_all", "show_canceled","filter_user","filter_user_id"];
			$active = 'current';
			if($_REQUEST['show_all'] === 'Y')
			{
				$active = 'show_all';
			}
			elseif ($_REQUEST['filter_history'] === 'Y' && $_REQUEST['show_canceled'] === 'Y')
			{
				$active = 'canceled';
			}
			elseif ($_REQUEST['filter_history'] === 'Y')
			{
				$active = 'completed';
			}elseif ($_REQUEST['filter_user'])
            {
                $active = 'user';
            }

			?>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper d-block pt-2">
					<span> </span>
					<a href="<?=$APPLICATION->GetCurPageParam('', $clearParams, false)?>" class="mb-2 btn <?=($active === 'current' ? 'btn-primary' : 'btn-default')?> btn-bold btn-upper btn-font-sm"><?=Loc::getMessage('SPOL_TPL_VIEW_ORDERS_CURRENT');?></a>
					<a href="<?=$APPLICATION->GetCurPageParam('filter_history=Y', $clearParams, false)?>" class="mb-2 btn <?=($active === 'completed' ? 'btn-primary' : 'btn-default')?> btn-bold btn-upper btn-font-sm"><?=Loc::getMessage('SPOL_TPL_VIEW_ORDERS_COMPLETED');?></a>
					<a href="<?=$APPLICATION->GetCurPageParam('filter_history=Y&show_canceled=Y', $clearParams, false)?>" class="mb-2 btn <?=($active === 'canceled' ? 'btn-primary' : 'btn-default')?> btn-bold btn-upper btn-font-sm"><?=Loc::getMessage('SPOL_TPL_VIEW_ORDERS_CANCELED');?></a>
					<a href="<?=$APPLICATION->GetCurPageParam("show_all=Y", $clearParams, false)?>" class="mb-2 btn <?=($active === 'show_all' ? 'btn-primary' : 'btn-default')?> btn-bold btn-upper btn-font-sm"><?=Loc::getMessage('SPOL_TPL_VIEW_ORDERS_ALL');?></a>
<!--                    <a href="--><?//=$APPLICATION->GetCurPageParam("filter_user=asd", $clearParams, false)?><!--" class="mb-2 btn --><?//=($active === 'user' ? 'btn-primary' : 'btn-default')?><!-- btn-bold btn-upper btn-font-sm">asd</a>-->
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:sale.personal.profile.list",
                        "profile_tab",
                        Array()
                    );?>

                </div>
			</div>
		</div>
		<?php
	});

	$body = $portlet->body(function () use ($blockId) {
		echo '<div id="' . $blockId . '"></div>';
	});

	$body->addModifier('fit');
	?>
	<div class="row">
		<div class="col-12 col-xl-9 order-2 order-xl-1">
			<div id="<?=$blockId?>_container"><?php $portlet->render(); ?></div>
		</div>
		<div class="col-12 col-xl-3 order-1 order-xl-2">
			<?php include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/filter.php'; ?>
		</div>
	</div>





	<script>


	(function () {
		BX.message(<?=CUtil::PhpToJSObject(Loc::loadLanguageFile(__FILE__))?>);

		var columns = <?=\Bitrix\Main\Web\Json::encode($arResult['COLUMNS'])?>;
		var rows = <?=\Bitrix\Main\Web\Json::encode($arResult['ROWS']); ?>;
		var navOptions = <?=\Bitrix\Main\Web\Json::encode($arResult['NAV_OPTIONS']); ?>;
		var sortOptions = <?=\Bitrix\Main\Web\Json::encode($arResult['SORT_OPTIONS']); ?>;
        console.log(rows);
		new B2BPortal.Components.SalePersonalOrderList(
			document.querySelector('#<?=$blockId?>'),
			document.querySelector('#<?=$blockId?>_container'),
			{
				rows: rows,
				columns: columns,
				pagination: navOptions,
				sort: sortOptions
			}
		);

	}());
	</script>

    <style>
        .tooltip_2 {
            position: relative;
            border-bottom: 1px dotted black;
        }

        .tooltip_2 .tooltiptext {
            visibility: hidden;
            width: fit-content;
            background-color: #253590 ;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 5px;
            position: absolute;
            z-index: 1;
            top: 130%;
            left: 50%;
            margin-left: -60px;
        }

        .tooltip_2:hover .tooltiptext {
            visibility: visible;
        }
    </style>
    <?php
}