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

/** @var CMain $APPLICATION */
global $APPLICATION;

if (count($arResult['ORDER_CHANGE_HISTORY']))
{
	$isCollapsed = in_array('order_history', $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('order_history', Loc::getMessage('SPOD_ORDER_CHANGE_HISTORY'), $isCollapsed, function () use (&$arResult, $APPLICATION) {

		?><table class="table">
			<thead>
			<tr>
				<th><?=Loc::getMessage('SPOD_ORDER_CHANGE_HISTORY_DATE_CREATE'); ?></th>
				<th><?=Loc::getMessage('SPOD_ORDER_CHANGE_HISTORY_NAME'); ?></th>
				<th><?=Loc::getMessage('SPOD_ORDER_CHANGE_HISTORY_DATE_INFO'); ?></th>
			</tr>
			</thead>
			<tbody>
				<?
				foreach ($arResult['ORDER_CHANGE_HISTORY'] as $historyData)
				{
					?>
					<tr>
						<td><?=$historyData['DATE_CREATE']?></td>
						<td><?=$historyData['NAME']?></td>
						<td><?=$historyData['INFO']?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		$APPLICATION->IncludeComponent(
			"bitrix:main.pagenavigation",
			"modern",
			array(
				"NAV_OBJECT" => $arResult['ORDER_CHANGE_HISTORY_NAV'],
				"SEF_MODE" => "N",
			),
			false
		);
	});
}
