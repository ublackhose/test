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


$this->addExternalJS($templateFolder . '/js/filter.js');
$this->addExternalJS($templateFolder . '/js/component.js');

$bDemo = (CTicket::IsDemo()) ? "Y" : "N";
$bAdmin = (CTicket::IsAdmin()) ? "Y" : "N";
$bSupportTeam = (CTicket::IsSupportTeam()) ? "Y" : "N";
$bADS = $bDemo == 'Y' || $bAdmin == 'Y' || $bSupportTeam == 'Y';

$blockId = 'claims_' . $this->randString(5);

$portlet = new Portlet();
$portlet->head(new Portlet\Head(function () use ($APPLICATION) {

	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('SUP_PORTLET_TITLE'));

	$this->toolbar(function () use ($APPLICATION) {

		$btnText = Loc::getMessage('SUP_ASK');

		echo <<<EOL
			<a class="btn btn-default btn-bold btn-upper btn-font-sm" href="{$APPLICATION->GetCurPage()}?ID=0&edit=1">
				<i class="flaticon2-add-1"></i>
				{$btnText}
			</a>
EOL;
	});
}));

$body = $portlet->body(function () use ($blockId, $bADS) {
	?>
	<div id="<?=$blockId?>"></div>

	<div class="p-4">
		<table class="support-ticket-hint">
			<tr>
				<td><div class="support-lamp-red"></div></td>
				<td> - <?=$bADS ? GetMessage("SUP_RED_ALT_SUP") : GetMessage("SUP_RED_ALT_2")?></td>
			</tr>
			<?if ($bADS):?>
				<tr>
					<td><div class="support-lamp-yellow"></div></td>
					<td> - <?=GetMessage("SUP_YELLOW_ALT_SUP")?></td>
				</tr>
			<?endif;?>
			<tr>
				<td><div class="support-lamp-green"></div></td>
				<td> - <?=GetMessage("SUP_GREEN_ALT")?></td>
			</tr>
			<?if ($bADS):?>
				<tr>
					<td><div class="support-lamp-green-s"></div></td>
					<td> - <?=GetMessage("SUP_GREEN_S_ALT_SUP")?></td>
				</tr>
			<?endif;?>
			<tr>
				<td><div class="support-lamp-grey"></div></td>
				<td> - <?=GetMessage("SUP_GREY_ALT")?></td>
			</tr>
		</table>
	</div>
	<?php
});

$body->addModifier('fit');

?>
<div class="row">
	<div class="col-md-9">
		<div id="<?=$blockId?>_container"><?php $portlet->render(); ?></div>
	</div>
	<div class="col-md-3">
		<?php include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/filter.php'; ?>
	</div>
</div>
<script>
(function () {

	BX.message({
		SUP_TICKET_NOT_FOUND: '<?=Loc::getMessage('SUP_TICKET_NOT_FOUND')?>'
	});

	var columns = <?=\Bitrix\Main\Web\Json::encode($arResult['PREPARED_COLUMNS'])?>;
	var rows = <?=\Bitrix\Main\Web\Json::encode($arResult["PREPARED_ROWS"]); ?>;
	var pagination = <?=\Bitrix\Main\Web\Json::encode($arResult["PREPARED_PAGINATION"]); ?>;
	var sort = <?=\Bitrix\Main\Web\Json::encode($arResult["PREPARED_SORT_OPTIONS"]); ?>;

	new B2BPortal.Components.SupportTicketList(
		document.querySelector('#<?=$blockId?>'),
		document.querySelector('#<?=$blockId?>_container'),
		{
			rows: rows,
			columns: columns,
			pagination: pagination,
			sort: sort
		}
	);

}());
</script>
<?