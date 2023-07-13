<?php

/**
 * @var CatalogElementComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $jsData
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$template = $component->getTemplate();

if (empty($arResult['GALLERY_ITEMS']))
{
	?>
	<div class="product-images-canvas">
		<img class="img-fluid product-images-main" src="<?=$template->GetFolder()?>/img/no-image.png" alt="" title="">
	</div>
	<?php
}
else
{
	?>
	<div class="mb-4">
		<div id="<?=$jsData['blockIds']['gallery']?>"></div>
	</div>
	<?php
}
