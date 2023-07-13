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


if (count($arResult['DOCUMENTS']) > 0)
{
	$isCollapsed = in_array('documents', $arResult['COLLAPSED_BLOCKS']);
	$renderBlock('documents', Loc::getMessage('SPOD_ORDER_DOCUMENTS'), $isCollapsed, function () use (&$arResult) {
		?><table class="table">
			<thead>
			<tr>
				<th><?=Loc::getMessage('SPOD_ORDER_DOCUMENT_DATE'); ?></th>
				<th><?=Loc::getMessage('SPOD_ORDER_DOCUMENT_NAME'); ?></th>
				<th><?=Loc::getMessage('SPOD_ORDER_DOCUMENT_TYPE'); ?></th>
				<th class="text-right"><?=Loc::getMessage('SPOD_ORDER_DOCUMENT_DOWNLOAD'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?
			foreach ($arResult['DOCUMENTS'] as $document)
			{
				?>
				<tr>
					<td>
					<?php if (!empty($document['DATE'])): ?>
						<?=$document['DATE']?>
					<?php endif; ?>
					</td>
					<td><?=$document['NAME']?></td>
					<td>
					<?php if (!empty($document['TYPE'])): ?>
						<span class="kt-badge kt-badge--inline kt-badge--pill kt-badge--<?=$document['TYPE']['XML_ID']?>">
							<?=$document['TYPE']['VALUE']?>
						</span>
					<?php endif; ?>
					</td>
					<td class="text-right">
						<?php if (!empty($document['FILE_PATH']) > 0): ?>
						<a href="<?=$document['FILE_PATH']?>" class="btn btn-primary btn-sm" target="_blank">
							<i class="flaticon2-download-2 pr-0"></i>
						</a>
						<?php endif; ?>
					</td>
				</tr>
				<?
			}
			?>
			</tbody>
		</table><?php
	});
}
