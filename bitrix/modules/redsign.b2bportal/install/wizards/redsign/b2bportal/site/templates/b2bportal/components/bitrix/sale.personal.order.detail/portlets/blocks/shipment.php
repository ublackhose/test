<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (count($arResult['SHIPMENT']))
{
	$isCollapsed = in_array('shipment', $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('shipment', Loc::getMessage('SPOD_ORDER_SHIPMENT'), $isCollapsed, function () use (&$arResult, &$arParams) {

		$shipmentCount = count($arResult['SHIPMENT']);
		$index = 0;

		foreach ($arResult['SHIPMENT'] as $shipment)
		{
			?><div class="<?=($index < $shipmentCount - 1 ? ' mb-5' : '')?>" >
				<h6>
				<?php
				//change date
				if (!strlen($shipment['PRICE_DELIVERY_FORMATED']))
				{
					$shipment['PRICE_DELIVERY_FORMATED'] = 0;
				}
				$shipmentRow = Loc::getMessage('SPOD_SUB_ORDER_SHIPMENT') . " " . Loc::getMessage('SPOD_NUM_SIGN') . $shipment["ACCOUNT_NUMBER"];
				if ($shipment["DATE_DEDUCTED"])
				{
					$shipmentRow .= " " . Loc::getMessage('SPOD_FROM') . " " . $shipment["DATE_DEDUCTED"]->format($arParams['ACTIVE_DATE_FORMAT']);
				}
				$shipmentRow = htmlspecialcharsbx($shipmentRow);
				$shipmentRow .= ", " . Loc::getMessage('SPOD_SUB_PRICE_DELIVERY', array(
						'#PRICE_DELIVERY#' => $shipment['PRICE_DELIVERY_FORMATED']
					));
				echo $shipmentRow;
				?>
				</h6>
				<?php
				if (strlen($shipment["DELIVERY_NAME"]))
				{
					?>
					<div class="d-block">
						<?= Loc::getMessage('SPOD_ORDER_DELIVERY')?>: <?= htmlspecialcharsbx($shipment["DELIVERY_NAME"])?>
					</div>
					<?
				}
				?>
				<div class="d-block">
					<?=Loc::getMessage('SPOD_ORDER_SHIPMENT_STATUS')?>:
					<?=htmlspecialcharsbx($shipment['STATUS_NAME'])?>
				</div>
				<?
				if (strlen($shipment['TRACKING_NUMBER']))
				{
					?>
					<div class="d-blcok">
						<?=Loc::getMessage('SPOD_ORDER_TRACKING_NUMBER')?>:
						<?=htmlspecialcharsbx($shipment['TRACKING_NUMBER'])?>
					</div>
					<?
				}
				?>
				<?php
				if (strlen($shipment['TRACKING_URL']))
				{
					?>
					<div class="d-block">
						<a href="<?=$shipment['TRACKING_URL']?>">
							<?= Loc::getMessage('SPOD_ORDER_CHECK_TRACKING')?>
						</a>
					</div>
					<?
				}
				?>
			</div>
			<?php
			$index++;
		}
	});
}
