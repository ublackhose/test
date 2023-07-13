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

<?php foreach ($arResult as $arItem): ?>
<a href="<?=$arItem['LINK']?>" target="_blank" class="kt-footer__menu-link kt-link"><?=$arItem['TEXT']?></a>
<?php endforeach; ?>
