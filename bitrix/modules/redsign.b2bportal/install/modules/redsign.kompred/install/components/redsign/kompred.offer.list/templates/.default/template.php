<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferList $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


\Bitrix\Main\UI\Extension::load('ui.fontawesome4');

if ($arResult['ERRORS'])
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm(Loc::getMessage('RS_KP_KOL_T_NO_ACCESS'), false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
else
{
	if ($arResult['MESSAGES']['SUCCESS'])
	{
		echo '<div class="alert alert-success">' .
			implode('<br>', $arResult['MESSAGES']['SUCCESS']) .
		'</div>';
	}

	if ($arResult['MESSAGES']['ERROR'])
	{
		echo '<div class="alert alert-warning">' .
			implode('<br>', $arResult['MESSAGES']['ERROR']) .
		'</div>';
	}

	if ($arParams['USE_SEARCH'])
	{
		?>
		<form method="GET" action="<?=$arResult['SEARCH']['ACTION']?>" name="offer_search" class="mb-4 d-flex">
			<input
				type="text"
				class="form-control mr-2"
				name="<?=$arResult['SEARCH']['VARIABLE']?>"
				value="<?=$arResult['SEARCH']['QUERY']?>"
				placeholder="<?=Loc::getMessage('RS_KP_KOL_T_SEARCH_PLACEHOLDER')?>"
			>
			<input type="submit" class="btn btn-primary" value="<?=Loc::getMessage('RS_KP_KOL_T_SEARCH');?>">
		</form>
		<?
	}

	if ($arResult['OFFERS'])
	{
		$productDeclension = new Bitrix\Main\Grid\Declension(
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_ONE'),
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_FOUR'),
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_FIVE')
		);

		?><div class="mw-100" style="overflow: auto;">
			<table class="table table-bordered">
				<thead class="thead-dark">
					<tr>
						<th><?=Loc::getMessage('RS_KP_KOL_T_TABLE_COL_NAME')?></th>
						<th><?=Loc::getMessage('RS_KP_KOL_T_TABLE_COL_DATE_CREATED')?></th>
						<th><?=Loc::getMessage('RS_KP_KOL_T_TABLE_COL_DATE_UPDATED')?></th>
						<th><?=Loc::getMessage('RS_KP_KOL_T_TABLE_COL_TOTAL')?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($arResult['OFFERS'] as $offer)
					{
						$productsCount = count($offer['PRODUCTS']);
						?><tr>
							<td class="align-middle">
								<a href="<?=$offer['EDIT_URL']?>" target="_blank" title="<?=Loc::getMessage('RS_KP_KOL_T_EDIT')?>">
									<?=htmlspecialcharsbx($offer['NAME'])?>
								</a>
							</td>
							<td class="align-middle"><?=$offer['DATE_CREATED']?></td>
							<td class="align-middle"><?=$offer['DATE_UPDATED']?></td>
							<td class="align-middle">
								<?=Loc::getMessage('RS_KP_KOL_T_TOTAL_VALUE', [
									'#COUNT#' => $productsCount,
									'#DECL_NOUN#' => $productDeclension->get($productsCount),
									'#TOTAL_PRICE#' => $offer['TOTAL_PRICE_FORMATTED']
								]);?>
							</td>
							<td class="align-middle text-center text-nowrap">
								<a
									class="btn btn-link"
									href="<?=$offer['DOWNLOAD_URL']?>"
									title="<?=Loc::getMessage('RS_KP_KOL_DOWNLOAD')?>"
								>
									<i class="fa fa-download" aria-hidden="true"></i>
								</a>
								<a
									class="btn btn-link"
									href="<?=$offer['EDIT_URL']?>"
									title="<?=Loc::getMessage('RS_KP_KOL_EDIT')?>"
								>
									<i class="fa fa-pencil" aria-hidden="true"></i>
								</a>
								<a
									class="btn btn-link"
									onclick="confirm('<?=Loc::getMessage('RS_KP_KOL_T_DELETE_CONFIRM') ?>') || event.preventDefault();"
									href="<?=$offer['DELETE_URL']?>"
									title="<?=Loc::getMessage('RS_KP_KOL_DELETE')?>"
								>
									<i class="fa fa-trash" aria-hidden="true"></i>
								</a>
							</td>
						</tr><?php
					}
					?>
				</tbody>
			</table>
		</div><?php

		?><div class="mt-5"><?php
			$APPLICATION->IncludeComponent(
				"bitrix:main.pagenavigation",
				"",
				array(
					"NAV_OBJECT" => $arResult['PAGE_NAV'],
					"SEF_MODE" => "Y",
				),
				$component,
				['HIDE_ICONS' => true]
			);
		?></div><?php
	}
	elseif (!empty($arResult['SEARCH']['QUERY']))
	{
		?><div class="alert alert-warning">
			<?=Loc::getMessage(
				'RS_KP_KOL_T_SEARCH_NOT_FOUND',
				['#SEARCH_QUERY#' => $arResult['SEARCH']['QUERY']]
			)?>
		</div><?
	}
	else
	{
		?><div class="alert alert-warning"><?=Loc::getMessage('RS_KP_KOL_T_EMPTY'); ?></div><?
	}
}
