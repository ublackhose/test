<?php

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arResult))
	return '';

$strReturn = '';

$strReturn .= '<div class="kt-subheader__breadcrumbs">';
	$strReturn .= '<a href="' . SITE_DIR . '" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]['TITLE']);

	$strReturn .= '<span class="kt-subheader__breadcrumbs-separator"></span>';

	if ($arResult[$index]["LINK"] <> '')
	{
		$strReturn .= '<a href="' . $arResult[$index]["LINK"] . '" class="kt-subheader__breadcrumbs-link">' . $title . '</a> ';
	}
	else
	{
		$strReturn .= '<span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">' . $title . '</span>';
	}
}

$strReturn .= '</div>';

return $strReturn;
