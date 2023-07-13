<?php

use Bitrix\Main\Engine\Response\Converter;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferList $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


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
	/* if ($arResult['OFFERS'])
	{ */
		$this->addExternalJS($templateFolder . '/dist/component.js');

		$randString = $this->randString();

		/** @var \Bitrix\Main\HttpRequest */
		$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
		$host = ($request->isHttps() ? 'https://' : 'http://') . $request->getHttpHost();

		$compId = 'kol_' . $randString;
		$blockId = 'kol_' . $randString;

		$productDeclension = new Bitrix\Main\Grid\Declension(
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_ONE'),
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_FOUR'),
			Loc::getMessage('RS_KP_KOL_T_TOTAL_PRODUCT_FIVE')
		);

		$columns = [];
		$columns[] = [
			'label' => Loc::getMessage('RS_KP_KOL_T_TABLE_COL_NAME'),
			'field' => 'name',
			'sortable' => false,
			'html' => false,
		];
		$columns[] = [
			'label' => Loc::getMessage('RS_KP_KOL_T_TABLE_COL_DATE_CREATED'),
			'field' => 'dateCreated',
			'sortable' => false,
			'html' => false,
		];
		$columns[] = [
			'label' => Loc::getMessage('RS_KP_KOL_T_TABLE_COL_DATE_UPDATED'),
			'field' => 'dateUpdated',
			'sortable' => false,
			'html' => false,
		];
		$columns[] = [
			'label' => Loc::getMessage('RS_KP_KOL_T_TABLE_COL_TOTAL'),
			'field' => 'total',
			'sortable' => false,
			'html' => false,
		];
		$columns[] = [
			'label' => '',
			'field' => 'actions',
			'sortable' => false,
			'html' => false,
		];

		$converter = Converter::toJson();

		$rows = $converter->process($arResult['OFFERS']);

		/** @var Bitrix\Main\UI\PageNavigation $pageNav */
		$pageNav = $arResult['PAGE_NAV'];
		$pagination = [
			'perPage' => $pageNav->getPageSize(),
			'paramName' => $pageNav->getId(),
			'currentPage' => $pageNav->getCurrentPage(),
			'totalRecords' => $pageNav->getRecordCount(),
			'pageCount' => $pageNav->getPageCount(),
			'sef' => true,
			'sefPath' => $pageNav->clearParams(new Uri($request->getRequestUri()), true)->getUri(),
			'pagePrefix' => 'page-'
		];

		$jsParams = [
			'id' => $compId,
			'columns' => $columns,
			'rows' => $rows,
			'pagination' => $pagination
		];

		$templateData = [];

		$templateData['COMP_ID'] = $compId;
		$templateData['ITEM_ROWS'] = $rows;
		$templateData['PAGINATION_OBJECT'] = $pageNav;
		$templateData['PAGINATION'] = $pagination;
		?>
		<div class="row">
			<div class="col-12 col-xl-9 order-2 order-xl-1">
				<?php
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
				?>
				<div class="kt-portlet kt-portlet--fit">
					<div class="kt-portlet__body">
						<div id="<?=$blockId?>"></div>
					</div>
				</div>
				<script>
				(function () {
					BX.message(<?=CUtil::PhpToJSObject(Loc::loadLanguageFile(__FILE__))?>);
					new B2BPortal.Components.KPList(
						document.getElementById('<?=$blockId?>'),
						<?=CUtil::PhpToJSObject($jsParams, false, false, true)?>
					);
				}());
				</script>
			</div>
			<div class="col-12 col-xl-3 order-1 order-xl-2">
				<?php
				if ($arParams['USE_SEARCH'])
				{
					?>
					<div class="kt-portlet">
						<div class="kt-portlet__head">
							<div class="kt-portlet__head-label">
								<h3 class="kt-portlet__head-title"><?=Loc::getMessage('RS_KP_KOL_T_SEARCH_TITLE')?></h3>
							</div>
						</div>
						<div class="kt-portlet__body">
							<form method="GET" action="<?=$arResult['SEARCH']['ACTION']?>" name="offer_search" class="mb-4 d-flex">

								<div class="input-group">
									<input
										type="text"
										class="form-control"
										name="<?=$arResult['SEARCH']['VARIABLE']?>"
										value="<?=$arResult['SEARCH']['QUERY']?>"
										placeholder="<?=Loc::getMessage('RS_KP_KOL_T_SEARCH_PLACEHOLDER')?>"
									>
									<div class="input-group-append">
										<input type="submit" class="btn btn-primary" value="<?=Loc::getMessage('RS_KP_KOL_T_SEARCH');?>">
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	/* }
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
	} */
}