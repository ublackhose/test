<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\Helpers\ArrHelper;

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

Loader::includeModule('redsign.b2bportal');

if ($arResult['ITEMS'])
{
	$elementEdit = \CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
	$elementDelete = \CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	$elementDeleteParams = ['CONFIRM' => Loc::getMessage('RS_B2BPORTAL_BNL_BG_ELEMENT_DELETE_CONFIRM')];

	?>
	<div class="row mb-4">
		<?php
		foreach ($arResult['ITEMS'] as $key => $item)
		{
			$background = ArrHelper::get($item, 'DISPLAY_PROPERTIES.BACKGROUND_IMAGE.FILE_VALUE');
			$link = ArrHelper::get($item, 'PROPERTIES.LINK.VALUE');
			$linkTarget = ArrHelper::get($item, 'PROPERTIES.LINK_TARGET.VALUE_XML_ID');
			$linkTarget = in_array($linkTarget, ['_blank', '_self', '_parent', '_top']) ? $linkTarget : '_self';
			$title = $item['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] ?: $item['NAME'];

			if (!$background)
				continue;

			$this->addEditAction($item['ID'], $item['EDIT_LINK'], $elementEdit);
			$this->addDeleteAction($item['ID'], $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
			?>
			<div class="col-xl-4">
				<div class="mb-4" id="<?=$this->getEditAreaId($item['ID'])?>">
					<?php if ($link): ?>
						<a
							href="<?=$link?>"
							<?=$linkTarget != '_self' ? 'target="' . $linkTarget . '"' : ''?>
						>
					<?php endif; ?>

					<img
						src="<?=$background['SRC']?>"
						class="img-fluid"
						alt="<?=$title?>"
						width="<?=$background['WIDTH']?>"
						height="<?=$background['HEIGHT']?>"
					/>

					<?php if ($link): ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
