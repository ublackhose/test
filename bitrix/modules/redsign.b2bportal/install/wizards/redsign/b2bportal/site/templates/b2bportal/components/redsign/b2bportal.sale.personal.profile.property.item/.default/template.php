<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RSB2BPortalPersonalProfilePropertyItem $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');

$parent = $component->GetParent();

$sBlockId = 'profilePropertyItem' . $this->randString(5);

$property = $arResult['PROPERTY'];
$key = (int)$property['ID'];
$name = 'ORDER_PROP_' . $key;
$currentValue = $arResult['ORDER_PROPS_VALUES'][$name];
$alignTop = ($property['TYPE'] === 'LOCATION' && $arParams['USE_AJAX_LOCATIONS'] === 'Y') ? 'vertical-align-top' : '';
?>
<div class="form-group row sale-personal-profile-detail-property-<?=strtolower($property["TYPE"])?>" id="spppi-property-id-<?=$key?>">
	<label class="col-12 col-md-4 text-right" for="sppd-property-<?=$key?>">
		<?=$property["NAME"]?>:
		<?php
		if ($property['REQUIRED'] == 'Y' || $property['REQUIED'] == 'Y')
		{
			?>
			<span class="sale-personal-profile-req">*</span>
			<?
		}
		?>
	</label>
	<div class="col-12 col-md-8">
		<?php
		if ($property["TYPE"] == "CHECKBOX" || $property["TYPE"] == 'Y/N')
		{
			?>
			<input
				class="sale-personal-profile-detail-form-checkbox"
				id="sppd-property-<?=$key?>"
				type="checkbox"
				name="<?=$name?>"
				value="Y"
				<?php
				if ($currentValue == "Y" || !isset($currentValue) && $property["DEFAULT_VALUE"] == "Y")
					echo " checked";
				?>
			/>
			<?php
		}
		elseif ($property["TYPE"] == "TEXT" || $property["TYPE"] == "TEXTAREA" || $property["TYPE"] == "STRING" || $property["TYPE"] == "NUMBER")
		{
			if ($property["TYPE"] == "TEXTAREA")
			{
				$textarea = true;
			}
			else
			{
				$textarea = (!empty($property['SETTINGS']['MULTILINE']) && $property['SETTINGS']['MULTILINE'] == 'Y') ? true : false;
			}

			if ($property["MULTIPLE"] === 'Y')
			{
				if (empty($currentValue) || !is_array($currentValue))
				{
					$currentValue = array('');
				}

				foreach ($currentValue as $elementValue)
				{
					if ($textarea):
						?>
						<textarea
							class="form-control mb-2"
							type="text"
							name="<?=$name?>[]"
							id="sppd-property-<?=$key?>"<?php
							if ($property['FIELD_TYPE'])
							{
								?>data-suggest-input="<?=$property['FIELD_TYPE']?>"<?
							}
							?>
							rows="<?=((int)($property["SIZE2"]) > 0) ? $property["SIZE2"] : 4; ?>"
							cols="<?=((int)($property["SIZE1"]) > 0) ? $property["SIZE1"] : 40; ?>"
						><?=(!empty($elementValue) ? $elementValue : $property["DEFAULT_VALUE"])?></textarea>
					<?php else: ?>
						<input
							class="form-control mb-2"
							type="text"
							name="<?=$name?>[]"
							id="sppd-property-<?=$key?>"<?php
							if ($property['FIELD_TYPE'])
							{
								?>data-suggest-input="<?=$property['FIELD_TYPE']?>"<?
							}
							?>
							value="<?=$elementValue?>"
						/>
					<?php endif; ?>
						<?php
				}

				if ($textarea):
					?>
					<span class="btn-themes btn-default btn-md btn input-add-multiple"
						data-add-type="TEXTAREA"
						data-add-name="<?=$name?>[]"><?=Loc::getMessage('SPPD_ADD')?></span>
				<?php else: ?>
					<span class="btn-themes btn-default btn-md btn input-add-multiple"
						data-add-type=<?=$property['TYPE']?>
						data-add-name="<?=$name?>[]"><?=Loc::getMessage('SPPD_ADD')?></span>
				<?php endif; ?>
				<?php
			}
			else
			{
				if ($textarea):
					?>
					<textarea
						class="form-control"
						type="text"
						name="<?=$name?>"
						id="sppd-property-<?=$key?>"<?php
						if ($property['FIELD_TYPE'])
						{
							?>data-suggest-input="<?=$property['FIELD_TYPE']?>"<?
						}
						?>
						rows="<?=((int)($property["SIZE2"]) > 0) ? $property["SIZE2"] : 4; ?>"
						cols="<?=((int)($property["SIZE1"]) > 0) ? $property["SIZE1"] : 40; ?>"
						><?=(!empty($currentValue) ? $currentValue : $property["DEFAULT_VALUE"])?></textarea>
				<?php else: ?>
					<input
						class="form-control"
						type="text"
						name="<?=$name?>"
						id="sppd-property-<?=$key?>"<?php
						if ($property['FIELD_TYPE'])
						{
							?>data-suggest-input="<?=$property['FIELD_TYPE']?>"<?
						}
						?>
						value="<?=$currentValue?>"
					/>
				<?php endif; ?>
				<?php
			}
		}
		elseif (
			$property["TYPE"] == "SELECT"
			|| ($property["TYPE"] == "ENUM" && $property["MULTIPLE"] != "Y" && $property["SETTINGS"]['MULTIELEMENT'] != "Y")
		) {
			?>
			<select
				class="form-control"
				name="<?=$name?>"
				id="sppd-property-<?=$key?>"
				size="<?=(intval($property["SIZE1"]) > 0) ? $property["SIZE1"] : 1; ?>">
				<?php
				foreach ($property["VALUES"] as $value)
				{
					?>
					<option value="<?= $value["VALUE"]?>" <?if ($value["VALUE"] == $currentValue || !isset($currentValue) && $value["VALUE"] == $property["DEFAULT_VALUE"]) echo " selected"?>>
						<?=$value["NAME"]?>
					</option>
					<?php
				}
				?>
			</select>
			<?php
		}
		elseif ($property["TYPE"] == "MULTISELECT" || ($property["TYPE"] == "ENUM" && $property["MULTIPLE"] == "Y"))
		{
			?>
			<select
				class="form-control"
				id="sppd-property-<?=$key?>"
				multiple name="<?=$name?>[]"
				size="<?=(intval($property["SIZE1"]) > 0) ? $property["SIZE1"] : 5; ?>">
				<?
				$arCurVal = array();
				$arCurVal = explode(",", $currentValue);
				for ($i = 0, $cnt = count($arCurVal); $i < $cnt; $i++)
					$arCurVal[$i] = trim($arCurVal[$i]);
				$arDefVal = explode(",", $property["DEFAULT_VALUE"]);
				for ($i = 0, $cnt = count($arDefVal); $i < $cnt; $i++)
					$arDefVal[$i] = trim($arDefVal[$i]);
				foreach($property["VALUES"] as $value)
				{
					?>
					<option value="<?= $value["VALUE"]?>"<?if (in_array($value["VALUE"], $arCurVal) || !isset($currentValue) && in_array($value["VALUE"], $arDefVal)) echo" selected"?>>
						<?=$value["NAME"]?>
					</option>
					<?php
				}
				?>
			</select>
			<?php
		}
		elseif ($property["TYPE"] == "LOCATION")
		{
			$locationTemplate = ($arParams['USE_AJAX_LOCATIONS'] !== 'Y') ? "popup" : "";
			$locationClassName = 'location-block-wrapper';
			if ($arParams['USE_AJAX_LOCATIONS'] === 'Y')
			{
				$locationClassName .= ' location-block-wrapper-delimeter';
			}
			if ($property["MULTIPLE"] === 'Y')
			{
				if (empty($currentValue) || !is_array($currentValue))
					$currentValue = array($property["DEFAULT_VALUE"]);

				foreach ($currentValue as $code => $elementValue)
				{
					$locationValue = intval($elementValue) ? $elementValue : $property["DEFAULT_VALUE"];
					CSaleLocation::proxySaleAjaxLocationsComponent(
						array(
							"ID" => "propertyLocation" . $name . "[$code]",
							"AJAX_CALL" => "N",
							'CITY_OUT_LOCATION' => 'Y',
							'COUNTRY_INPUT_NAME' => $name . '_COUNTRY',
							'CITY_INPUT_NAME' => $name . "[$code]",
							'LOCATION_VALUE' => $locationValue,
						),
						array(
						),
						$locationTemplate,
						true,
						$locationClassName . ' mb-2'
					);
				}
				?>
				<span class="btn-themes btn-default btn-md btn input-add-multiple"
					data-add-type=<?=$property["TYPE"]?>
					data-add-name="<?=$name?>"
					data-add-last-key="<?=$code?>"
					data-add-template="<?=$locationTemplate?>"><?=Loc::getMessage('SPPD_ADD')?></span>
				<?php
			}
			else
			{
				$locationValue = (int)($currentValue) ? (int)$currentValue : $property["DEFAULT_VALUE"];

				CSaleLocation::proxySaleAjaxLocationsComponent(
					array(
						"AJAX_CALL" => "N",
						'CITY_OUT_LOCATION' => 'Y',
						'COUNTRY_INPUT_NAME' => $name . '_COUNTRY',
						'CITY_INPUT_NAME' => $name,
						'LOCATION_VALUE' => $locationValue,
					),
					array(
					),
					$locationTemplate,
					true,
					'location-block-wrapper'
				);
			}
		}
		elseif (
			$property["TYPE"] == "RADIO"
			|| ($property["TYPE"] == "ENUM" && $property["MULTIPLE"] != "Y" && $property["SETTINGS"]['MULTIELEMENT'] == "Y")
		)
		{
			foreach ($property['VALUES'] as $value)
			{
				?>
				<div class="radio">
					<input
						type="radio"
						id="sppd-property-<?=$key?>"
						name="<?=$name?>"
						value="<?= $value["VALUE"]?>"
						<?php
						if ($value["VALUE"] == $currentValue || !isset($currentValue) && $value["VALUE"] == $property["DEFAULT_VALUE"])
							echo " checked"
						?>
					>
					<?=$value["NAME"]?>
				</div>
				<?php
			}
		}
		elseif ($property["TYPE"] == "FILE")
		{
			$multiple = ($property['MULTIPLE'] == 'Y') ? 'multiple' : '';
			$profileFiles = is_array($currentValue) ? $currentValue : array($currentValue);
			?><div class="sale-personal-profile-detail-property-file">
				<?php
				if (!empty($currentValue) > 0 && count($currentValue) > 0)
				{
					?>
					<input type="hidden" name="<?=$name?>_del" class="profile-property-input-delete-file">
					<?php
					foreach ($profileFiles as $file)
					{
						?>
						<div class="sale-personal-profile-detail-form-file">
							<?
							$fileId = $file['ID'];
							if (CFile::IsImage($file['FILE_NAME']))
							{
								?>
								<div class="sale-personal-profile-detail-prop-img">
									<?=CFile::ShowImage($fileId, 150, 150, "border=0", "", true)?>
								</div>
								<?
							}
							else
							{
								?>
								<a download="<?=$file["ORIGINAL_NAME"]?>" href="<?=CFile::GetFileSRC($file)?>">
									<?=Loc::getMessage('SPPD_DOWNLOAD_FILE', array("#FILE_NAME#" => $file["ORIGINAL_NAME"]))?>
								</a>
								<?
							}
							?>
							<input type="checkbox" value="<?=$fileId?>" class="profile-property-check-file" id="profile-property-check-file-<?=$fileId?>">
							<label for="profile-property-check-file-<?=$fileId?>"><?=Loc::getMessage('SPPD_DELETE_FILE')?></label>
						</div>
						<?
					}
				}
				?>
				<label>
					<span class="btn-themes btn-default btn-md btn">
						<?=Loc::getMessage('SPPD_SELECT')?>
					</span>
					<span class="sale-personal-profile-detail-load-file-info">
						<?=($multiple == 'multiple' ? Loc::getMessage('SPPPI_FILE_NOT_SELECTED_MULTIPLE') : Loc::getMessage('SPPPI_FILE_NOT_SELECTED'))?>
					</span>
					<?=CFile::InputFile($name . "[]", 20, null, false, 0, "IMAGE", "class='btn sale-personal-profile-detail-input-file' " . $multiple)?>
				</label>
				<span class="sale-personal-profile-detail-load-file-cancel sale-personal-profile-hide"></span>
			</div>
			<?
		}
		elseif ($property["TYPE"] == "DATE")
		{
			$showTime = $property['SETTINGS']['TIME'] == 'Y' ? true : false;

			if ($property["MULTIPLE"] === 'Y')
			{
				if (empty($currentValue) || !is_array($currentValue))
					$currentValue = array('');
				foreach ($currentValue as $elementValue)
				{
					?>
					<div class="input-group mb-2 date">
						<input
							class="form-control js-calendar<?=($showTime ? '-time' : '')?>"
							type="text" name="<?=$name?>[]"
							id="sppd-property-<?=$key?>"
							value="<?=$elementValue?>"
							autocomplete="off"
						/>
						<div class="input-group-append">
							<span class="input-group-text"><i class="la la-clock-o glyphicon-th"></i></span>
						</div>
					</div>
					<?
				}
				?>
				<span class="btn-themes btn-default btn-md btn input-add-multiple"
					data-add-type="<?=$property["TYPE"]?><?=($showTime ? '_TIME' : '')?>"
					data-add-name="<?=$name?>[]"><?=Loc::getMessage('SPPD_ADD')?></span>
				<?
			}
			else
			{
				?>
				<div class="input-group date">
					<input
						class="form-control js-calendar<?=($showTime ? '-time' : '')?>"
						type="text" name="<?=$name?>"
						id="sppd-property-<?=$key?>"
						value="<?=$currentValue?>"
						autocomplete="off"
					/>
					<div class="input-group-append">
						<span class="input-group-text"><i class="la la-clock-o glyphicon-th"></i></span>
					</div>
				</div>
				<?
			}
		}

		if (strlen($property["DESCRIPTION"]) > 0)
		{
			?>
			<br /><small><?= $property["DESCRIPTION"] ?></small>
			<?
		}
		?>
	</div>
</div>

<?php
$jsData = [
	'id' => \CUtil::JSEscape('spppi-property-id-' . $key),
	'ajaxUrl' => \CUtil::JSEscape($parent->GetPath() . '/ajax.php'),
	'messages' => [
		'SPPPI_FILE_COUNT' => Loc::getMessage('SPPPI_FILE_COUNT'),
		'SPPPI_FILE_NOT_SELECTED' => Loc::getMessage('SPPPI_FILE_NOT_SELECTED'),
		'SPPPI_FILE_NOT_SELECTED_MULTIPLE' => Loc::getMessage('SPPPI_FILE_NOT_SELECTED_MULTIPLE'),
	]
];
?>

<script>
(function () {

	new SalePersonalProfilePropertyItem(
		<?=\Bitrix\Main\Web\Json::encode($jsData)?>
	);

}());
</script>
