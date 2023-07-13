<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferCreate $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!empty($arResult['ERRORS']))
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm($arResult['ERRORS'][$component::ERROR_NO_ACCESS], false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
