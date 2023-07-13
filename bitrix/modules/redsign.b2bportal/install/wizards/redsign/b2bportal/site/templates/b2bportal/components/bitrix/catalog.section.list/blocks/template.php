<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (empty($arResult['SECTIONS']))
	return;

$this->addExternalJS($templateFolder . '/src/component.js');

$strSectionEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_EDIT');
$strSectionDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_DELETE');
$arSectionDeleteParams = ['CONFIRM' => Loc::getMessage('RS_B2BPORTAL_CSLB_ELEMENT_DELETE_CONFIRM')];

$sBlockId = 'sectionListBlocks' . $this->randString(5);

?><div class="row"><?

foreach ($arResult['NEW_ITEMS'] as $arItem)
{
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strSectionEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

	?><div class="col-xl-4" id="<?=$this->GetEditAreaId($arItem['ID'])?>"><?

	$portlet = new Portlet();

	$portlet->body(function () use ($arItem, $sBlockId) {

		if (!empty($arItem['PICTURE']))
		{
			?>
			<div class="row">
				<div class="col-12 col-xs-6 col-md-4 text-center">
					<img
						class="img-fluid"
						src="<?=$arItem['PICTURE']['SAFE_SRC']?>"
						alt="<?=$arItem['PICTURE']['ALT']?>"
						title="<?=$arItem['PICTURE']['TITLE']?>"
					>
				</div>
				<div class="col-12 col-xs-6 col-md-8">
					<h4><a href="<?=$arItem['SECTION_PAGE_URL']?>"><?=$arItem['NAME']?></a></h4>
					<?php if (!empty($arItem['CHILDREN'])): ?>
						<div>
						<?php foreach ($arItem['CHILDREN'] as $arChild): ?>
						<a class="mr-2" href="<?=$arChild['SECTION_PAGE_URL']?>"><?=$arChild['NAME']?></a>
						<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		else
		{
			?>
			<div class="row">
				<div class="col-12" id="<?=$sBlockId?>">
					<h4><a href="<?=$arItem['SECTION_PAGE_URL']?>"><?=$arItem['NAME']?></a></h4>
					<?php if (!empty($arItem['CHILDREN'])): ?>
						<div>
						<?php foreach ($arItem['CHILDREN'] as $arChild): ?>
						<a class="mr-2" href="<?=$arChild['SECTION_PAGE_URL']?>"><?=$arChild['NAME']?></a>
						<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
	});

	$portlet->addModifier('height-fluid');

	$portlet->render();

	?></div><?
}

?></div><?
