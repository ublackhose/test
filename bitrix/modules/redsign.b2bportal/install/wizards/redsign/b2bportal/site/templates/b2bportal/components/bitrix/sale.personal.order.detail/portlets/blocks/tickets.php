<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CBitrixPersonalOrderDetailComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var \Closure $renderBlock
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


/** @var CMain $APPLICATION */
global $APPLICATION;

$template = $component->getTemplate();

$template->addExternalCss(SITE_TEMPLATE_PATH . '/components/bitrix/support.wizard/claims/redsign/b2bportal.support.ticket.list/.default/style.css');

if (\Bitrix\Main\Loader::includeModule('support') && $APPLICATION->GetGroupRight('support') >= 'R')
{
	$isCollapsed = in_array('tickets', $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('tickets', Loc::getMessage('SPOD_ORDER_TICKETS'), $isCollapsed, function () use (&$arResult) {

		if (count($arResult['TICKETS']) > 0)
		{
			?><table class="table">
				<thead>
				<tr>
					<th></th>
					<th><?=Loc::getMessage('SPOD_ORDER_TICKET_ID')?></th>
					<th><?=Loc::getMessage('SPOD_ORDER_TICKET_NAME')?></th>
					<th><?=Loc::getMessage('SPOD_ORDER_TICKET_TIMESTAMP_X')?></th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach ($arResult['TICKETS'] as $ticket)
				{
					?>
					<tr>
						<td class="align-middle">
							<div class="support-lamp-<?=str_replace('_', '-', $ticket['LAMP'])?>"></div>
						</td>
						<td class="align-middle">
							<div><a href="<?=$ticket['TICKET_EDIT_URL']?>"><?=$ticket['ID']?></a></div>
							<div class="text-muted"><?=$ticket['DATE_CREATE']?></div>
						</td>
						<td class="align-middle">
							<a href="<?=$ticket['TICKET_EDIT_URL']?>"><?=$ticket['TITLE']?></a>
						</td>
						<td class="align-middle">
							<?=$ticket['TIMESTAMP_X']?>
						</td>
					</tr>
					<?
				}
				?>
				</tbody>
			</table>
			<?php
		}
		else
		{
			?><?=Loc::getMessage('SPOD_ORDER_TICKETS_NOT_FOUND')?><?
		}
		?>

		<hr>
		<div class="d-block text-right">
			<?php if (count($arResult['TICKETS']) > 0): ?>
				<a href="<?=$arResult['TICKET_LIST']?>" class="btn btn-outline-primary btn-sm" ><?=Loc::getMessage('SPOD_ORDER_TICKETS_ALL')?></a>
			<?php endif; ?>
			<a href="<?=$arResult['ADD_TICKET']?>" class="btn btn-primary btn-sm"><?=Loc::getMessage('SPOD_ORDER_ADD_TICKET')?></a>
		</div>
		<?php
	});
}
