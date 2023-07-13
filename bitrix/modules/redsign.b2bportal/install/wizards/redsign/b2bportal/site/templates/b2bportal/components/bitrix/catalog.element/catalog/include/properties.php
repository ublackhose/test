<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arParams['PROPERTY_CODE']))
	return;

$skipProps = array_merge([], $arParams['LINES_PROPERTIES']);

$displayProps = array_filter($arResult['DISPLAY_PROPERTIES'], function ($property) use ($skipProps) {
	return !in_array($property['CODE'], $skipProps) && $property['USER_TYPE'] !== 'redsign_custom_filter';
});

if (!$displayProps)
	return;

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () {

	/** @var Portlet\Head $this */
	$this->title(function () {
		echo Loc::getMessage('RS.B2BPORTAL.TAB.PROPERTIES');
	});
}));

$body = $portlet->body(function () use ($displayProps) {
	foreach ($displayProps as $property):
		if (!empty($property['DISPLAY_VALUE'])):
			?>
			<div class="form-group form-group-sm row">
				<label class="col-12 col-md-4 col-form-label"><?=$property['NAME']?></label>
				<div class="col-12 col-md-4">
					<div class="form-control-plaintext"><?
					if (is_array($property['DISPLAY_VALUE'])):
						echo implode('&nbsp;/&nbsp;', $property['DISPLAY_VALUE']);
					else:
							echo $property['DISPLAY_VALUE'];
					endif;
					?></div>
				</div>
			</div>
			<?php
		endif;
	endforeach;
});

$portlet->render();
