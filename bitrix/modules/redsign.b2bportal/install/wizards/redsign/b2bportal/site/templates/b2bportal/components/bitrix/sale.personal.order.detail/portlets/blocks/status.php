<?php

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (isset($arResult['STATUS']['COLOR']) && strlen($arResult['STATUS']['COLOR']) > 0)
{
	echo '<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary ml-2 align-middle" style="background-color: ' . $arResult['STATUS']['COLOR'] . '">' . $arResult['STATUS']['NAME'] . '</span>';
}
else
{
	echo '<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary ml-2 align-middle">' . $arResult['STATUS']['NAME'] . '</span>';
}
