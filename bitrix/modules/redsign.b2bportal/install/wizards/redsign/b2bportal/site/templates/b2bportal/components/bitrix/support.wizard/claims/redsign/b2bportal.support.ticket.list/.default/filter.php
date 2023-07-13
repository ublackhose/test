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

$this->addExternalJs($templateFolder . '/../../../js/OrderSuggestions.js');
?>
<form>
<?php
$portlet2 = new Portlet();

$portlet2->head(new Portlet\Head(function () use ($APPLICATION) {
	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('SUP_F_FILTER'));
}));

$portlet2->body(function () use ($arResult, $component) {
	$template = $component->getTemplate();
	$gridOptions = new CGridOptions($arResult["GRID_ID"]);
	$filterValues = $gridOptions->GetFilter($arResult["FILTER"]);
	?>
	<div class="row">
		<?php
		foreach ($arResult['FILTER'] as $filterParams):
			$isList = isset($filterParams['type']) && $filterParams['type'] == 'list';

			if ($isList):
				$isMultiple = isset($filterParams['params']['multiple']) && $filterParams['params']['multiple'] == 'multiple';
				$valuesList = $filterValues[$filterParams['id']] ?: [];
				?>
				<div class="col-12">
					<div class="form-group">
						<label><?=$filterParams['name']?></label>
						<?php if ($isMultiple): ?>
						<select name="<?=$filterParams['id']?>[]" class="form-control" multiple>
							<?php foreach ($filterParams['items'] as $value => $name): ?>
							<option value="<?=$value?>"<?=(in_array($value, $valuesList) ? ' selected' : '')?>><?=$name?></option>
							<?php endforeach; ?>
						</select>
						<?php else: ?>
						<select name="<?=$filterParams['id']?>" class="form-control">
							<?php foreach ($filterParams['items'] as $value => $name): ?>
							<option value="<?=$value?>" <?=($value == $valuesList ? ' selected' : '')?>><?=$name?></option>
							<?php endforeach; ?>
						</select>
						<?php endif; ?>
					</div>
				</div>
			<?php else: ?>
				<div class="col-12">
					<?php if($filterParams['id'] !== 'UF_ORDER_ID'): ?>
					<div class="form-group">
						<label><?=$filterParams['name']?></label>
						<input type="text" name="<?=$filterParams['id']?>" value="<?=$filterValues[$filterParams['id']]?>" class="form-control">
					</div>
					<?php else: ?>
					<div class="form-group">
						<label><?=$filterParams['name']?></label>
						<?php $bId = 'input_' . strtolower($filterParams['id']) . '_' . $template->randString(5); ?>
						<div id="<?=$bId?>"></div>

						<script>
						(function () {
							new B2BPortal.Components.OrderSuggestions(document.getElementById('<?=$bId?>'), {
								value: '<?=$filterValues[$filterParams['id']]?>',
								inputName: '<?=$filterParams['id']?>'
							});
						}());
						</script>
					</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="col-12">
			<div class="form-group form-group-last">
				<input type="submit" name="filter" class="btn btn-primary" value="<?=Loc::getMessage('SUP_FILTER_APPLY');?>">
				<input type="button" name="filter_reset" class="btn btn-secondary" value="<?=Loc::getMessage('SUP_FILTER_CLEAR')?>" onclick="B2BPortal.SupportTickets.clearFilter(this.form)">
			</div>
		</div>
	</div>
	<?
});
$portlet2->render();
?>
</form>