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
	$this->title(Loc::getMessage('SUP_TICKET_TITLE_FULL', [
		'#ID#' => $arResult['TICKET']['ID'],
		'#TITLE#' => $arResult['TICKET']['TITLE'],
	]));

	$this->toolbar(function () use ($arResult) {
		?><form name="support_edit" method="post" action="<?=$arResult["REAL_FILE_PATH"]?>">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="set_default" value="Y">
			<input type="hidden" name="ID" value=<?=(empty($arResult["TICKET"]) ? 0 : $arResult["TICKET"]["ID"])?>>
			<input type="hidden" name="edit" value="1">
			<input type="hidden" name="lang" value="<?=LANG?>">
			<input type="hidden" name="CATEGORY_ID" value="<?=$arResult['TICKET']['CATEGORY_ID']?>">
			<input type="hidden" name="apply" value="Y">
			<?php
			if (strlen($arResult["TICKET"]["DATE_CLOSE"]) <= 0)
			{
				?>
				<input type="hidden" name="CLOSE" value="Y">
				<input type="submit" class="btn btn-danger" type="button" value="<?=Loc::getMessage('SUP_CLOSE_TICKET')?>">
				<?php
			}
			else
			{
				?>
				<input type="hidden" name="OPEN" value="Y">
				<input type="submit" class="btn btn-success" type="button" value="<?=Loc::getMessage('SUP_OPEN_TICKET');?>">
				<?php
			}
			?>
		<form>
		<?php
	});
}));

$body = $portlet->body(function () use ($arResult) {
	global $DB;

	$lastField = 'DATE_CREATE';
	$hasOrder = $hasResponsible = $hasCategory = $hasStatus = false;

	if (isset($arResult['TICKET']['ORDER']))
	{
		$lastField = 'ORDER';
		$hasOrder = true;
	}

	if ((int) $arResult['TICKET']['RESPONSIBLE_USER_ID'] > 0)
	{
		$lastField = 'RESPONSIBLE_USER';
		$hasResponsible = true;
	}

	if (strlen($arResult['TICKET']['CATEGORY_NAME']) > 0)
	{
		$lastField = 'CATEGORY';
		$hasCategory = true;
	}

	if (strlen($arResult['TICKET']['STATUS_NAME']) > 0)
	{
		$lastField = 'STATUS_NAME';
		$hasStatus = true;
	}
	?>
	<form class="kt-form">

		<div class="form-group<?=($lastField == 'DATE_CREATE' ? 'form-group-last' : '')?>">
			<label><?=Loc::getMessage('SUP_CREATE') ?></label>
			<p class="form-control-static"><?=FormatDate($DB->DateFormatToPHP(CSite::GetDateFormat('FULL')), MakeTimeStamp($arResult["TICKET"]["DATE_CREATE"]))?></p>
		</div>

		<?php if ($hasOrder): ?>
		<div class="form-group<?($lastField == 'ORDER' ? ' form-group-last' : '')?>">
			<label><?=Loc::getMessage('SUP_TICKET_ORDER') ?></label>
			<div>
				<?=Loc::getMessage('SUP_TICKET_ORDER_LINK', [
					'#DETAIL_PAGE#' => $arResult['TICKET']['ORDER']['DETAIL_PAGE'],
					'#ORDER_NUMBER#' => $arResult['TICKET']['ORDER']['ACCOUNT_NUMBER']
				]);

				$statusColor = $arResult['TICKET']['ORDER']['STATUS_COLOR'];
				?>
				<span class="kt-badge kt-badge--inline kt-badge--primary mr-2"<?=($statusColor ? ' style="background-color: ' . $statusColor . '"' : '')?>>
					<?=$arResult['TICKET']['ORDER']['STATUS_NAME']?>
				</span>
				<?php if ($arResult['TICKET']['ORDER']['PAYED'] !== 'N'): ?>
				<div>
					<span class="kt-badge kt-badge--success kt-badge--inline"><?=Loc::getMessage('SUP_TICKET_ORDER_PAYED')?></span>
					<?php if (isset($arResult['TICKET']['ORDER']['FORMATTED_DATE_PAYED'])): ?>
						<?=Loc::getMessage('SUP_TICKET_ORDER_PAYED_FROM', [
							'#DATE_PAYED#' => $arResult['TICKET']['ORDER']['FORMATTED_DATE_PAYED']
						]);?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($hasResponsible):?>
		<div class="form-group<?=($lastField == 'RESPONSIBLE_USER' ? ' form-group-last' : '')?>">
			<label><?=Loc::getMessage('SUP_RESPONSIBLE') ?></label>
			<div class="form-control-static">(<?=$arResult["TICKET"]["RESPONSIBLE_LOGIN"]?>) <?=$arResult["TICKET"]["RESPONSIBLE_NAME"]?></div>
		</div>
		<?php endif; ?>

		<?php if ($hasCategory):?>
		<div class="form-group<?=($lastField == 'CATEGORY' ? ' form-group-last' : '')?>">
			<label><?=Loc::getMessage('SUP_CATEGORY') ?></label>
			<div class="form-control-static"> <span title="<?=$arResult["TICKET"]["CATEGORY_DESC"]?>"><?=$arResult["TICKET"]["CATEGORY_NAME"]?></span></div>
		</div>
		<?php endif; ?>

		<?php if ($hasStatus) :?>
		<div class="form-group<?=($lastField == 'STATUS_NAME' ? ' form-group-last' : '')?>">
			<label><?=Loc::getMessage('SUP_STATUS') ?></label>
			<div class="form-control-static"><?=$arResult["TICKET"]["STATUS_NAME"]?></div>
		</div>
		<?php endif; ?>

	</form>
	<?
});

$portlet->sticky();

$portlet->render();?>