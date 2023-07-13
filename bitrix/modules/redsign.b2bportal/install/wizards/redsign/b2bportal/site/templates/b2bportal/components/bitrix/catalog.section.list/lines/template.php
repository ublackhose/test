<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

if (empty($arResult['SECTIONS']))
	return;

$arParams['BLOCK_TITLE'] = Loc::getMessage('RS_B2BPORTAL_CSLL_BLOCK_TITLE');


$sBlockId = 'sectionListLines' . $this->randString(5);

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($arParams) {
	/** @var Portlet\Head $this */
	$this->title($arParams['BLOCK_TITLE']);
}));

$body = $portlet->body(function () use ($arResult, $component, $arParams) {

	$template = $component->getTemplate();

	$strSectionEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_EDIT');
	$strSectionDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_DELETE');
	$arSectionDeleteParams = ['CONFIRM' => Loc::getMessage('RS_B2BPORTAL_CSLL_ELEMENT_DELETE_CONFIRM')];

	echo '<ul class="list-group mb-0 rs-news-list-lines">';

	foreach ($arResult['SECTIONS'] as $arSection)
	{
		$template->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$template->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

		echo <<<EOL
			<li class="list-group-item" id="{$template->GetEditAreaId($arSection['ID'])}">
				<a class="list-group-item-link" href="{$arSection['SECTION_PAGE_URL']}">
					<span class="list-group-item-name">{$arSection['NAME']}</span>
				</a>
			</li>
EOL;
	}

	echo '</ul>';
});

$body->addModifier('fit');

$portlet->render();
