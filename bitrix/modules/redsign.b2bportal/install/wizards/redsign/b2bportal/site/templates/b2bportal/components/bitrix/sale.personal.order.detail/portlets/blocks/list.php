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


if (!empty($arResult['BASKET']))
{
	$isCollapsed = in_array('list', $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('list', Loc::getMessage('SPOD_ORDER_LIST'), $isCollapsed, function () use (&$arResult) {
		?>
		<table class="table">
			<thead>
			<tr>
				<th scope="col"><?= Loc::getMessage('SPOD_NAME')?></th>
				<th scope="col"><?= Loc::getMessage('SPOD_PRICE')?></th>
				<?
				if (strlen($arResult["SHOW_DISCOUNT_TAB"]))
				{
					?>
					<th scope="col"><?= Loc::getMessage('SPOD_DISCOUNT') ?></th>
					<?
				}
				?>
				<th scope="col"><?= Loc::getMessage('SPOD_QUANTITY')?></th>
				<th class="text-right"><?= Loc::getMessage('SPOD_ORDER_PRICE')?></th>
			</tr>
			</thead>
			<tbody>
			<?
			foreach ($arResult['BASKET'] as $basketItem)
			{
				?>
				<tr>
					<td class="sale-order-detail-order-item-properties" style="min-width: 250px;">
						<a class="sale-order-detail-order-item-title"
							href="<?=$basketItem['DETAIL_PAGE_URL']?>"><?=htmlspecialcharsbx($basketItem['NAME'])?></a>
						<? if (isset($basketItem['PROPS']) && is_array($basketItem['PROPS']))
						{
							foreach ($basketItem['PROPS'] as $itemProps)
							{
								?>
								<div class="sale-order-detail-order-item-properties-type"><?=htmlspecialcharsbx($itemProps['VALUE'])?></div>
								<?
							}
						}
						?>
					</td>
					<td class="sale-order-detail-order-item-properties">
						<span class="bx-price"><?=$basketItem['BASE_PRICE_FORMATED']?></span>
					</td>
					<?
					if (strlen($basketItem["DISCOUNT_PRICE_PERCENT_FORMATED"]))
					{
						?>
						<td class="sale-order-detail-order-item-properties text-right">
							<?= $basketItem['DISCOUNT_PRICE_PERCENT_FORMATED'] ?>
						</td>
						<?
					}
					elseif (strlen($arResult["SHOW_DISCOUNT_TAB"]))
					{
						?>
						<td class="sale-order-detail-order-item-properties text-right">
							<strong class="bx-price"></strong>
						</td>
						<?
					}
					?>
					<td class="sale-order-detail-order-item-properties">
						<?=$basketItem['QUANTITY']?>&nbsp;
						<?
						if (strlen($basketItem['MEASURE_NAME']))
						{
							echo htmlspecialcharsbx($basketItem['MEASURE_NAME']);
						}
						else
						{
							echo Loc::getMessage('SPOD_DEFAULT_MEASURE');
						}
						?>
					</td>
					<td class="sale-order-detail-order-item-properties text-right">
						<strong class="bx-price"><?=$basketItem['FORMATED_SUM']?></strong>
					</td>
				</tr>
				<?
			}
			?>
			</tbody>
		</table>
		<?php
	});
}
