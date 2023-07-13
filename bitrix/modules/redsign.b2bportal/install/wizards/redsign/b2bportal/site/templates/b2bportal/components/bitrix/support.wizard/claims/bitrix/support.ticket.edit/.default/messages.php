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


$portlet = new Portlet();
$portlet->head(new Portlet\Head(function () use ($arResult) {

	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('SUP_TICKET_TITLE', [
		'#ID#' => $arResult['TICKET']['ID'],
		'#TITLE#' => $arResult['TICKET']['TITLE'],
	]));
}));

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

$body = $portlet->body(function () use ($arResult, $componentPath) {
	foreach ($arResult["MESSAGES"] as $index => $arMessage):
		?>
		<div <?=($index % 2 == 1) ? 'class="bg-light"' : ''?>>
			<div class="pt-4 pr-5 pb-4 pl-5">
				<div class="row mb-2">
					<div class="col-12">
						<strong>
							#<?=$arMessage['ID']?>
							-
							<?php if ($arMessage['MESSAGE_BY_SUPPORT_TEAM'] == 'Y'): ?>
							<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--info"><?=Loc::getMessage('SUP_MESSAGE_BY_SUPPORT_TEAM');?></span>
							<?php else: ?>
							<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--success"><?=Loc::getMessage('SUP_MESSAGE_BY_CLIENT')?></span>
							<?php endif; ?>

							<?php if ((int) $arMessage["OWNER_USER_ID"] > 0):?>
								(<?=$arMessage["OWNER_LOGIN"]?>) <?=$arMessage["OWNER_NAME"]?>
							<?endif?>
						</strong> | <span class="text-muted"><?=$arMessage['TIMESTAMP_X']?></span>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<?php /**<img class="float-left mr-3 mb-3" src="https://portal.redsign.ru/bitrix/components/redsign/support.ticket.edit/templates/.default/images/ticket-avatar-placeholder.png"> **/?>
						<div class=""><?=$arMessage['MESSAGE']?></div>
						<?php
						$aImg = array("gif", "png", "jpg", "jpeg", "bmp");
						if (isset($arMessage['FILES']) && count($arMessage['FILES']) > 0)
						{
							?><div class="mt-3">
								<?php
								foreach ($arMessage['FILES'] as $arFile)
								{
									?><div class="d-block">
										<?php
										if (in_array(strtolower(GetFileExtension($arFile['NAME'])), $aImg))
										{
											?><a title="<?=Loc::getMessage("SUP_VIEW_ALT")?>" target="__blank" href="<?=$componentPath?>/ticket_show_file.php?hash=<?=$arFile["HASH"]?>&amp;lang=<?=LANG?>"><?=$arFile["NAME"]?></a> <?
										}
										else
										{
											?><?=$arFile['NAME']?><?php
										}
										?>
										(<?php echo CFile::FormatSize($arFile["FILE_SIZE"]); ?>)
										[<a title="<?=Loc::getMessage("SUP_DOWNLOAD_ALT", ['#FILE_NAME#' => $arFile["NAME"]])?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?=$arFile["HASH"]?>&amp;lang=<?=LANG?>&amp;action=download"><?=Loc::getMessage("SUP_DOWNLOAD")?></a>]
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	endforeach;
})->addModifier('fit');

$portlet->render();?>