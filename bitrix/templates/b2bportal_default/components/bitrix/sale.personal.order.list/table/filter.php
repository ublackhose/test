<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixPersonalOrderListComponent $component
 * @var array $arParams
 * @var array $arResult
 */
?>

<form>
<?php
$portlet2 = new Portlet();

$portlet2->head(new Portlet\Head(function () {
	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER'));
}));

$portlet2->body(function () use ($arResult) {

	$skip = ['filter_status', 'filter_payed'];
	foreach ($_REQUEST as $key => $value)
	{
		if (!in_array($key, $skip))
		{
			?><input type="hidden" name="<?=htmlspecialcharsbx($key)?>" value="<?=htmlspecialcharsbx($value)?>"><?
		}
	}

	?>
	<div class="row">
		<div class="col-12">
			<div class="form-group">
				<?php
				$dateFrom = isset($_REQUEST['filter_date_from']) ? htmlspecialcharsbx($_REQUEST['filter_date_from']) : '';
				$dateTo = isset($_REQUEST['filter_date_to']) ? htmlspecialcharsbx($_REQUEST['filter_date_to']) : '';
				?>
				<label><?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_DATE_INSERT')?></label>
				<div class="input-daterange input-group" id="kt_datepicker_5">
					<input type="text" class="form-control " name="filter_date_from" value="<?=$dateFrom?>" autocomplete="off">
					<div class="input-group-append">
						<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
					</div>
					<input type="text" class="form-control" name="filter_date_to" value="<?=$dateTo?>" autocomplete="off">
				</div>
			</div>
			<?php if (is_array($arResult['STATUSES']) && count($arResult['STATUSES']) > 0): ?>
			<div class="form-group">
				<?php $selected = $_REQUEST['filter_status'] ?? ''; ?>
				<label><?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_STATUS')?></label>
				<select name="filter_status" class="form-control">
					<option value=""> <?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_ALL');?></option>
					<?php foreach ($arResult['STATUSES'] as $statusId => $status): ?>
					<option value="<?=$statusId?>" <?=($statusId == $selected ? ' selected' : '')?>><?=$status['name']?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php endif; ?>
			<div class="form-group">
				<?php $isChecked = isset($_REQUEST['filter_payed']) ? htmlspecialcharsbx($_REQUEST['filter_payed']) === 'Y' : false;?>
				<label class="kt-checkbox">
					<input type="checkbox" name="filter_payed" value="Y"<?=($isChecked ? ' checked' : '')?>> <?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_PAYED')?>
					<span></span>
				</label>
			</div>
			<div class="form-group form-group-last">
				<input type="submit" class="btn btn-primary" value="<?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_APPLY');?>">
				<input type="button" class="btn btn-secondary" value="<?=Loc::getMessage('RS_B2BPORTAL_SPOL_FILTER_CLEAR')?>" onclick="clearFilter(this.form)">
			</div>
		</div>
	</div>

	<?php
	$dateFormat = str_replace(
		['DD', 'MM', 'YYYY'],
		['dd', 'mm', 'yyyy'],
		CSite::GetDateFormat('SHORT')
	);
	?>
	<script>
	(function() {
		var options = {
			format: '<?=$dateFormat?>',
			language: BX.Loc.getMessage('LANGUAGE_ID')
		};

		$('[name="filter_date_from"]').datepicker(options);
		$('[name="filter_date_to"]').datepicker(options);

	}());
	function clearFilter(form)
	{
		for(var i=0, n=form.elements.length; i<n; i++)
		{
			var el = form.elements[i];
			switch(el.type.toLowerCase())
			{
				case 'text':
				case 'textarea':
					el.value = '';
					break;
				case 'select-one':
					el.selectedIndex = 0;
					break;
				case 'select-multiple':
					for(var j=0, l=el.options.length; j<l; j++)
						el.options[j].selected = false;
					break;
				case 'checkbox':
					el.checked = false;
					break;
				default:
					break;
			}
			if(el.onchange)
				el.onchange();
		}

		// form.clear_filter.value = "Y";

		BX.submit(form);
	}
	</script>
	<?
});
$portlet2->render();
?>
</form>