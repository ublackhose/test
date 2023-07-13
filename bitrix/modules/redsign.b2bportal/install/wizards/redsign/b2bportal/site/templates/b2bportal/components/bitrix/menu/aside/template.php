<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixMenuComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arResult))
	return;
?>

<ul class="kt-menu__nav">
<?php
$previousLevel = 0;
foreach ($arResult as $arItem):
	?>
	<?php if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
		<?=str_repeat('</ul></div></li>', ($previousLevel - $arItem['DEPTH_LEVEL']));?>
	<?php endif; ?>

	<?php if ($arItem['IS_PARENT']): ?>
		<li class="kt-menu__item<?=($arItem['SELECTED'] ? ' kt-menu__item--open' : '')?>">
			<a
				class="kt-menu__link kt-menu__toggle"
				href="javascript:;"
			>
				<?php if (!empty($arItem['PARAMS']['ICON'])): ?>
					<i class="kt-menu__link-icon <?=$arItem['PARAMS']['ICON']?>"></i>
				<?php endif; ?>
				<span class="kt-menu__link-text"><?=$arItem['TEXT']?></span>
				<i class="kt-menu__ver-arrow la la-angle-right"></i>
			</a>
			<div class="kt-menu__submenu">
				<ul class="kt-menu__subnav">

	<?php else: ?>

		<?php if ($arItem['PERMISSION'] > 'D'): ?>
			<li class="kt-menu__item<?=($arItem['SELECTED'] ? ' kt-menu__item--active' : '')?>">
				<a class="kt-menu__link" href="<?=$arItem['LINK']?>">
					<?php if (!empty($arItem['PARAMS']['ICON']) && $arItem['DEPTH_LEVEL'] == 1): ?>
						<i class="kt-menu__link-icon <?=$arItem['PARAMS']['ICON']?>"></i>
					<?php else: ?>
						<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
					<?php endif; ?>
					<span class="kt-menu__link-text"><?=$arItem['TEXT']?></span>
				</a>
			</li>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	$previousLevel = $arItem['DEPTH_LEVEL'];
	?>

<?php endforeach; ?>

<?php if ($previousLevel > 1): ?>
	<?=str_repeat('</ul></div></li>', ($previousLevel - 1));?>
<?php endif; ?>

</ul>
