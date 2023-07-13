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


$this->addExternalJs($templateFolder . '/../../../js/OrderSuggestions.js');

if (!empty($arResult['TICKET']) && strlen($arResult["TICKET"]["DATE_CLOSE"]) != 0)
{
	return;
}

$templateData['ERROR_MESSAGE'] = $arResult["ERROR_MESSAGE"];

Portlet::simple(
	(empty($arResult['TICKET']) ? Loc::getMessage('SUP_TICKET') : Loc::getMessage('SUP_ANSWER')),
	function () use ($arResult, $arParams, $APPLICATION, $component) {
		$template = $component->getTemplate();
		?>
		<form name="support_edit" method="post" action="<?=$arResult["REAL_FILE_PATH"]?>" enctype="multipart/form-data">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="set_default" value="Y">
			<input type="hidden" name="ID" value=<?=(empty($arResult["TICKET"]) ? 0 : $arResult["TICKET"]["ID"])?>>
			<input type="hidden" name="edit" value="1">
			<input type="hidden" name="lang" value="<?=LANG?>">

			<div class="row justify-content-center">

				<div class="col-md-6">
					<div class="text-center alert alert-danger<?=(empty($arResult['ERROR_MESSAGE']) ? ' d-none' : '')?>" data-error-message>
						<?=is_array($arResult['ERROR_MESSAGE']) ? implode('<br>', $arResult['ERROR_MESSAGE']) : $arResult['ERROR_MESSAGE'];?>
					</div>

					<?php if (empty($arResult["TICKET"])): ?>
					<div class="form-group">
						<label><?=Loc::getMessage('SUP_TITLE')?> <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="TITLE" value="<?=htmlspecialcharsbx($_REQUEST["TITLE"])?>">
					</div>
					<?php endif; ?>

					<div class="form-group">
						<label><?=Loc::getMessage('SUP_MESSAGE')?> <span class="text-danger">*</span></label>
						<textarea name="MESSAGE" id="MESSAGE" class="form-control"><?=htmlspecialcharsbx($_REQUEST["MESSAGE"])?></textarea>
					</div>

					<?php
					if (isset($arParams["SET_SHOW_USER_FIELD_T"]))
					{
						foreach ($arParams["SET_SHOW_USER_FIELD_T"] as $k => $v)
						{
							if ($k === 'UF_ORDER_ID')
							{
								if (empty($arResult['TICKET']))
								{
									$bId = 'input_' . strtolower($k) . '_' . $template->randString(5);
									?>
									<div class="form-group">
										<label><?=Loc::getMessage('SUP_ORDER')?></label>
										<div id="<?=$bId?>"></div>

										<script>
										(function () {
											new B2BPortal.Components.OrderSuggestions(document.getElementById('<?=$bId?>'), {
												value: '<?=isset($_REQUEST['UF_ORDER_ID']) ? htmlspecialcharsbx(urldecode($_REQUEST['UF_ORDER_ID'])) : '' ?>',
												inputName: '<?=$v['ALL']['FIELD_NAME']?>'
											});
										}());
										</script>
									</div>
									<?
								}
							}
							else
							{
								?><div class="form-group">
									<?php
									$v["ALL"]["VALUE"] = $arParams[$k];
									?>
									<label><?=htmlspecialcharsbx($v['NAME_F'])?></label>
									<?php
									$APPLICATION->IncludeComponent(
										'bitrix:system.field.edit',
										$v["ALL"]['USER_TYPE_ID'],
										array(
											'arUserField' => $v["ALL"],
										),
										null,
										array('HIDE_ICONS' => 'Y')
									);
									?>
								</div>
								<?php
							}
						}
					}
					?>

					<div class="form-group">
						<label><?=Loc::getMessage('SUP_CRITICALITY');?></label>
						<?php
						if (empty($arResult["TICKET"]) || strlen($arResult["ERROR_MESSAGE"]) > 0)
						{
							if (strlen($arResult["DICTIONARY"]["CRITICALITY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
							{
								$criticality = $arResult["DICTIONARY"]["CRITICALITY_DEFAULT"];
							}
							else
							{
								$criticality = htmlspecialcharsbx($_REQUEST["CRITICALITY_ID"]);
							}
						}
						else
						{
							$criticality = $arResult["TICKET"]["CRITICALITY_ID"];
						}
						?>
						<select name="CRITICALITY_ID" id="CRITICALITY_ID" class="form-control">
							<option value="">&nbsp;</option>
							<?php foreach ($arResult["DICTIONARY"]["CRITICALITY"] as $value => $option):?>
								<option value="<?=$value?>"<?=($criticality == $value ? ' selected="selected"' : '')?>><?=$option?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<?php if (empty($arResult["TICKET"])): ?>
						<div class="form-group">
							<label><?=Loc::getMessage('SUP_CATEGORY');?></label>
							<?php
							if (strlen($arResult["DICTIONARY"]["CATEGORY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
							{
								$category = $arResult["DICTIONARY"]["CATEGORY_DEFAULT"];
							}
							else
							{
								$category = htmlspecialcharsbx($_REQUEST["CATEGORY_ID"]);
							}
							?>
							<select name="CATEGORY_ID" id="CATEGORY_ID" class="form-control">
								<option value="">&nbsp;</option>
								<?php foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option): ?>
									<option value="<?=$value?>"<?=($category == $value ? ' selected="selected"' : '')?>><?=$option?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php else: ?>
						<input type="hidden" name="CATEGORY_ID" value="<?=$arResult['TICKET']['CATEGORY_ID']?>"?>
					<?php endif; ?>

					<div class="form-group">
						<div class="dropzone dropzone-multi">
							<div class="dropzone-panel">
								<a class="dropzone-select btn btn-label-brand btn-bold btn-sm dz-clickable"><?=Loc::getMessage('SUP_ATTACH'); ?></a> (max - <?=$arResult["OPTIONS"]["MAX_FILESIZE"]?> <?=Loc::getMessage("SUP_KB")?>)
							</div>
							<div class="dropzone-items"></div>
						</div>
					</div>

					<div class="form-group">
						<input type="submit" name="save" value="<?=Loc::getMessage("SUP_SAVE")?>" class="btn btn-primary">&nbsp;
						<input type="submit" name="apply" value="<?=Loc::getMessage("SUP_APPLY")?>" class="btn btn-secondary">&nbsp;
						<input type="hidden" value="Y" name="apply" />
					</div>

				</div>
			</div>
		</form>
		<?php
	}
)->render();