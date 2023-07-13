<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $blockName
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$groupId = substr($blockName, strlen('order_group_'));

if (isset($arResult['ORDER_PROPS_GROUPS'][$groupId]))
{
	$group = $arResult['ORDER_PROPS_GROUPS'][$groupId];
	$isCollapsed = in_array('order_group_' . $groupId, $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('order_group_' . $groupId, $group['NAME'], $isCollapsed, function () use ($group) {
		foreach ($group["PROPS"] as $property)
		{
			?>
			<div class="mb-4">
				<h6><?= htmlspecialcharsbx($property['NAME']) ?>:</h6>
				<p class="mb-0">
					<?php
					if ($property['TYPE'] == 'Y/N')
					{
						echo Loc::getMessage('SPOD_' . ($property["VALUE"] == "Y" ? 'YES' : 'NO'));
					}
					else
					{
						if (
							$property['MULTIPLE'] == 'Y'
							&& $property['TYPE'] !== 'FILE'
							&& $property['TYPE'] !== 'LOCATION'
						)
						{
							$propertyList = unserialize($property["VALUE"]);
							foreach ($propertyList as $propertyElement)
							{
								echo $propertyElement . '</br>';
							}
						}
						elseif ($property['TYPE'] == 'FILE')
						{
							echo $property["VALUE"];
						}
						else
						{
							echo htmlspecialcharsbx($property["VALUE"]);
						}
					}
					?>
				</p>
			</div>
			<?
		}
	});
}
