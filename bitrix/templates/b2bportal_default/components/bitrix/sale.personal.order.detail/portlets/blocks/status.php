<?php

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();



$arStatus = CSaleStatus::GetByID($arResult['STATUS']['ID']);




if (isset($arResult['STATUS']['COLOR']) && strlen($arResult['STATUS']['COLOR']) > 0)
{
	echo '<span title = "'.$arStatus['DESCRIPTION'].'" class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary ml-2 align-middle tooltip_2" style="background-color: ' . $arResult['STATUS']['COLOR'] . '">' . $arResult['STATUS']['NAME'] . '<span  class="tooltiptext">'.$arStatus['DESCRIPTION'].'</span></span>';
}
else
{
	echo '<span title = "'.$arStatus['DESCRIPTION'].'" class="kt-badge kt-badge--inline kt-badge--pill kt-badge--primary ml-2 align-middle tooltip_2">' . $arResult['STATUS']['NAME'] . '<span  class="tooltiptext">'.$arStatus['DESCRIPTION'].'</span></span>';
}
