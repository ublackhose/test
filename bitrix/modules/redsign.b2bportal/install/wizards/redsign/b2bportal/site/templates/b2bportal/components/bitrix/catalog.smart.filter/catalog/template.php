<?php

use Bitrix\Main\Loader;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixCatalogSmartFilter $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!Loader::includeModule('redsign.b2bportal'))
	return;

$this->setFrameMode(true);

$sBlockId = 'filter-' . $this->randString(5);
$collapseId = $sBlockId . '_collapse';

$portlet = new Portlet();
$portlet->head(new Portlet\Head(function () use ($collapseId) {

	/** @var Portlet\Head $this */
	$this->title(GetMessage("CT_BCSF_FILTER_TITLE"));

	$this->toolbar(function () use ($collapseId) {
		echo <<<EOL
			<a href="#{$collapseId}" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="collapse">
				<i class="fa fa-angle-down pr-0"></i>
			</a>
EOL;
	});
}));

$portlet->body(function () use ($arResult, $arParams, $sBlockId, $APPLICATION) {
	?>
<div class="smart-filter mb-0 <?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL") echo "smart-filter-horizontal"?>" id="<?=$sBlockId?>">
	<div class="smart-filter-section">

		<form name="<?=$arResult["FILTER_NAME"] . "_form"?>" action="<?=$arResult["FORM_ACTION"]?>" method="get" class="smart-filter-form">
			<?foreach($arResult["HIDDEN"] as $arItem): if (in_array($arItem['CONTROL_NAME'], $arParams['SKIP_HIDDEN_PROPS'])) continue; ?>
				<input type="hidden" name="<?=$arItem["CONTROL_NAME"]?>" id="<?=$arItem["CONTROL_ID"]?>" value="<?=$arItem["HTML_VALUE"]?>" />
			<?endforeach;?>
			<input type="hidden" name="hide_not_available">

			<div class="row">
				<?php if ($arParams['FILTER_ENABLE_HIDE_NOT_AVAILABLE'] == 'Y'): ?>
				<div class="col-12 mb-2 smart-filter-parameters-box bx-active">
					<span class="smart-filter-container-modef"></span>
					<label class="kt-checkbox">
						<input type="checkbox"<?=($arParams['HIDE_NOT_AVAILABLE'] == 'Y' ? ' checked' : '')?> onchange="smartFilter.hideNotAvailable(this)">
						<?=GetMessage('CT_BCSF_FILTER_INSTOCK')?>
						<span></span>
					</label>
				</div>
				<?php endif; ?>

				<?foreach($arResult["ITEMS"] as $key => $arItem)//prices
				{
					$key = $arItem["ENCODED_ID"];
					if(isset($arItem["PRICE"])):
						if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
							continue;

						$step_num = 4;
						$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
						$prices = array();
						$precision = 0;
						if (Bitrix\Main\Loader::includeModule("currency"))
						{
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
							}
							$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
						}
						else
						{
							$precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
							for ($i = 0; $i < $step_num; $i++)
							{
								$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * $i, $precision, ".", "");
							}
							$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
						}
						?>

						<div class="<?=($arParams['FILTER_VIEW_MODE'] == 'HORIZONTAL' ? 'col-sm-6 col-md-4' : 'col-12')?> mb-2 smart-filter-parameters-box bx-active">
							<span class="smart-filter-container-modef"></span>

							<div class="smart-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">
								<span class="smart-filter-parameters-box-title-text"><?=$arItem["NAME"]?></span>
								<span data-role="prop_angle" class="smart-filter-angle smart-filter-angle-up">
									<span class="smart-filter-angles"></span>
								</span>
							</div>

							<div class="smart-filter-block" data-role="bx_filter_block">
								<div class="smart-filter-parameters-box-container">
									<div class="smart-filter-input-group-number">
										<div class="d-flex justify-content-between">
											<div class="form-group" style="width: calc(50% - 10px);">
												<div class="smart-filter-input-container">
													<input
														class="min-price form-control form-control-sm"
														type="number"
														name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
														id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
														value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
														size="5"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>

											<div class="form-group" style="width: calc(50% - 10px);">
												<div class="smart-filter-input-container">
													<input
														class="max-price form-control form-control-sm"
														type="number"
														name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
														id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
														value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
														size="5"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>
										</div>

										<div class="smart-filter-slider-track-container">
											<div class="smart-filter-slider-track" id="drag_track_<?=$key?>">
												<?for($i = 0; $i <= $step_num; $i++):?>
												<div class="smart-filter-slider-ruler p<?=$i + 1?>"><span><?=$prices[$i]?></span></div>
												<?endfor;?>
												<div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-range" id="drag_tracker_<?=$key?>" style="left: 0; right: 0;">
													<a class="smart-filter-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
													<a class="smart-filter-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?

						$arJsParams = array(
							"leftSlider" => 'left_slider_' . $key,
							"rightSlider" => 'right_slider_' . $key,
							"tracker" => "drag_tracker_" . $key,
							"trackerWrap" => "drag_track_" . $key,
							"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
							"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
							"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
							"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
							"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
							"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
							"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
							"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
							"precision" => $precision,
							"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
							"colorAvailableActive" => 'colorAvailableActive_' . $key,
							"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
						);
						?>
						<script type="text/javascript">
							BX.ready(function(){
								window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
							});
						</script>
					<?endif;
				}

				//not prices
				foreach($arResult["ITEMS"] as $key => $arItem)
				{
					if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
						continue;

					if ($arItem["DISPLAY_TYPE"] == "A" && ( $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
						continue;
					?>

					<div class="<?=($arParams['FILTER_VIEW_MODE'] == 'HORIZONTAL' ? 'col-sm-6 col-md-4' : 'col-12')?> mb-2 smart-filter-parameters-box<?=($arItem['DISPLAY_EXPANDED'] == 'Y' ? ' bx-active' : '')?>">
						<span class="smart-filter-container-modef"></span>

						<div class="smart-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)">

							<span class="smart-filter-parameters-box-title-text"><?=$arItem["NAME"]?></span>

							<span data-role="prop_angle" class="smart-filter-angle smart-filter-angle-<?=($arItem['DISPLAY_EXPANDED'] == 'Y' ? 'up' : 'down')?>">
								<span class="smart-filter-angles"></span>
							</span>

							<?if ($arItem["FILTER_HINT"] <> ""):?>
								<span class="smart-filter-hint">
									<span class="smart-filter-hint-icon">?</span>
									<span class="smart-filter-hint-popup">
										<span class="smart-filter-hint-popup-angle"></span>
										<span class="smart-filter-hint-popup-content">

										</span>	<?=$arItem["FILTER_HINT"]?></span>
								</span>
							<?endif?>
						</div>

						<div class="smart-filter-block" data-role="bx_filter_block">
							<div class="smart-filter-parameters-box-container">
							<?
							$arCur = current($arItem["VALUES"]);
							switch ($arItem["DISPLAY_TYPE"])
							{
								//region NUMBERS_WITH_SLIDER +
								case "A":
									?>
									<div class="smart-filter-input-group-number">
										<div class="d-flex justify-content-between">

											<div class="form-group" style="width: calc(50% - 10px);">
												<div class="smart-filter-input-container">
													<input class="min-price form-control form-control-sm"
														type="number"
														name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
														id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
														value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
														size="5"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>

											<div class="form-group" style="width: calc(50% - 10px);">
												<div class="smart-filter-input-container">
													<input
														class="max-price form-control form-control-sm"
														type="number"
														name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
														id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
														value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
														size="5"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
														onkeyup="smartFilter.keyup(this)"
													/>
												</div>
											</div>

										</div>

										<div class="smart-filter-slider-track-container">
											<div class="smart-filter-slider-track" id="drag_track_<?=$key?>">
												<?
													$precision = $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0;
													$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
													$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
													$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
													$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
													$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
													$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
												?>
												<div class="smart-filter-slider-ruler p1"><span><?=$value1?></span></div>
												<div class="smart-filter-slider-ruler p2"><span><?=$value2?></span></div>
												<div class="smart-filter-slider-ruler p3"><span><?=$value3?></span></div>
												<div class="smart-filter-slider-ruler p4"><span><?=$value4?></span></div>
												<div class="smart-filter-slider-ruler p5"><span><?=$value5?></span></div>

												<div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
												<div class="smart-filter-slider-price-bar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
												<div class="smart-filter-slider-range" id="drag_tracker_<?=$key?>" style="left: 0;right: 0;">
													<a class="smart-filter-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
													<a class="smart-filter-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
												</div>
											</div>
										</div>
									</div>

									<?
										$arJsParams = array(
										"leftSlider" => 'left_slider_' . $key,
										"rightSlider" => 'right_slider_' . $key,
										"tracker" => "drag_tracker_" . $key,
										"trackerWrap" => "drag_track_" . $key,
										"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
										"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
										"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
										"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
										"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
										"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
										"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
										"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
										"precision" => $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0,
										"colorUnavailableActive" => 'colorUnavailableActive_' . $key,
										"colorAvailableActive" => 'colorAvailableActive_' . $key,
										"colorAvailableInactive" => 'colorAvailableInactive_' . $key,
									);
									?>
										<script type="text/javascript">
											BX.ready(function(){
												window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
											});
										</script>
									<?

									break;

								//endregion

								//region NUMBERS +
								case "B":
									?>
									<div class="smart-filter-input-group-number">
										<div class="d-flex justify-content-between">
											<div class="form-group" style="width: calc(50% - 10px);">
												<div class="smart-filter-input-container">
													<input
														class="min-price form-control form-control-sm"
														type="number"
														name="<?=$arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
														id="<?=$arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
														value="<?=$arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
														size="5"
														placeholder="<?=GetMessage("CT_BCSF_FILTER_FROM")?>"
														onkeyup="smartFilter.keyup(this)"
														/>
												</div>
											</div>

											<div class="form-group" style="width: calc(50% - 10px);">
											<div class="smart-filter-input-container">
												<input
													class="max-price form-control form-control-sm"
													type="number"
													name="<?=$arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
													id="<?=$arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
													value="<?=$arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
													size="5"
													placeholder="<?=GetMessage("CT_BCSF_FILTER_TO")?>"
													onkeyup="smartFilter.keyup(this)"
													/>
											</div>
										</div>
										</div>
									</div>
									<?php
									break;
								//endregion

								//region CHECKBOXES_WITH_PICTURES +
								case "G":
									?>
									<div class="smart-filter-input-group-checkbox-pictures">
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
											<input
												style="display: none"
												type="checkbox"
												name="<?=$ar["CONTROL_NAME"]?>"
												id="<?=$ar["CONTROL_ID"]?>"
												value="<?=$ar["HTML_VALUE"]?>"
												<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
											/>
											<?
												$class = "";
												if ($ar["CHECKED"])
													$class .= " bx-active";
												if ($ar["DISABLED"])
													$class .= " disabled";
											?>
											<label for="<?=$ar["CONTROL_ID"]?>"
												   data-role="label_<?=$ar["CONTROL_ID"]?>"
												   class="smart-filter-checkbox-label<?=$class?>"
												   onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
												<span class="smart-filter-checkbox-btn bx-color-sl">
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
														<span class="smart-filter-checkbox-btn-image" style="background-image: url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
												</span>
											</label>
										<?endforeach?>
										<div style="clear: both;"></div>
									</div>
									<?php
									break;
								//endregion

								//region CHECKBOXES_WITH_PICTURES_AND_LABELS +
								case "H":
									?>
									<div class="smart-filter-input-group-checkbox-pictures-text">
										<?foreach ($arItem["VALUES"] as $val => $ar):?>
										<input
											style="display: none"
											type="checkbox"
											name="<?=$ar["CONTROL_NAME"]?>"
											id="<?=$ar["CONTROL_ID"]?>"
											value="<?=$ar["HTML_VALUE"]?>"
											<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
										/>
											<?php
											$class = "";
											if ($ar["CHECKED"])
												$class .= " bx-active";
											if ($ar["DISABLED"])
												$class .= " disabled";
											?>
										<label for="<?=$ar["CONTROL_ID"]?>"
											   data-role="label_<?=$ar["CONTROL_ID"]?>"
											   class="smart-filter-checkbox-label<?=$class?>"
											   onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
											<span class="smart-filter-checkbox-btn">
												<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
													<span class="smart-filter-checkbox-btn-image" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
												<?endif?>
											</span>
											<span class="smart-filter-checkbox-text mb-0" title="<?=$ar["VALUE"];?>">
												<?=$ar["VALUE"];
												if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
													?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]; ?></span>)<?
												endif;?>
											</span>
										</label>
										<?endforeach?>
									</div>
									<?php
									break;
								//endregion

								//region DROPDOWN +
								case "P":
									?>
									<? $checkedItemExist = false; ?>

									<div class="btn-group">
										<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-role="currentOption">
											<?foreach ($arItem["VALUES"] as $val => $ar)
												{
												if ($ar["CHECKED"])
												{
													echo $ar["VALUE"];
													$checkedItemExist = true;
												}
											}
											if (!$checkedItemExist)
											{
												echo GetMessage("CT_BCSF_FILTER_ALL");
											}
											?>
										</button>

										<div class="dropdown-menu dropdown-menu-right">
											<label class="dropdown-item" href="#" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_" . $arCur["CONTROL_ID"])?>')">
												<input
													style="display: none;"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<?="all_" . $arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?=GetMessage("CT_BCSF_FILTER_ALL"); ?>
										</label>
											<div class="dropdown-divider"></div>
											<?foreach ($arItem["VALUES"] as $val => $ar):
												$class = "";
												if ($ar["CHECKED"])
													$class .= " selected";
												if ($ar["DISABLED"])
													$class .= " disabled";
												?>
												<label class="dropdown-item" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
														<input
															style="display: none;"
															type="radio"
															name="<?=$ar["CONTROL_NAME_ALT"]?>"
															id="<?=$ar["CONTROL_ID"]?>"
															value="<?=$ar["HTML_VALUE_ALT"] ?>"
															<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
														/>
														<?=$ar["VALUE"]?>
												</label>
											<?php endforeach; ?>
										</div>
									</div>
									<?php
									break;
								//endregion

								case "R":
									$checkedItemExist = false; ?>
									<div class="btn-group">
										<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-role="currentOption">
											<?foreach ($arItem["VALUES"] as $val => $ar)
												{
												if ($ar["CHECKED"])
												{
													echo $ar["VALUE"];
													$checkedItemExist = true;
												}
											}
											if (!$checkedItemExist)
											{
												echo GetMessage("CT_BCSF_FILTER_ALL");
											}
											?>
										</button>

										<div class="dropdown-menu dropdown-menu-right">
											<label class="dropdown-item" href="#" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_" . $arCur["CONTROL_ID"])?>')">
												<input
													style="display: none;"
													type="radio"
													name="<?=$arCur["CONTROL_NAME_ALT"]?>"
													id="<?="all_" . $arCur["CONTROL_ID"] ?>"
													value=""
												/>
												<?=GetMessage("CT_BCSF_FILTER_ALL"); ?>
										</label>
											<div class="dropdown-divider"></div>
											<?foreach ($arItem["VALUES"] as $val => $ar):
												$class = "";
												if ($ar["CHECKED"])
													$class .= " selected";
												if ($ar["DISABLED"])
													$class .= " disabled";
												?>
												<label class="dropdown-item" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
													<input
														style="display: none;"
														type="radio"
														name="<?=$ar["CONTROL_NAME_ALT"]?>"
														id="<?=$ar["CONTROL_ID"]?>"
														value="<?=$ar["HTML_VALUE_ALT"] ?>"
														<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
													/>
													<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
														<span class="mr-2 smart-filter-checkbox-btn-image" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
													<?endif?>
													<?=$ar["VALUE"]?>
												</label>
											<?php endforeach; ?>
										</div>
									</div><?
									break;

								//region RADIO_BUTTONS
								case "K":
									?>
									<div class="col">
										<div class="radio">
											<label class="smart-filter-param-label" for="<?="all_" . $arCur["CONTROL_ID"] ?>">
												<div class="smart-filter-input-checkbox kt-radio mb-0">
													<input
														type="radio"
														value=""
														name="<?=$arCur["CONTROL_NAME_ALT"] ?>"
														id="<?="all_" . $arCur["CONTROL_ID"] ?>"
														onclick="smartFilter.click(this)"
													/>
													<span></span>
													<div class="smart-filter-param-text"><?=GetMessage("CT_BCSF_FILTER_ALL"); ?></div>
												</div>
											</label>
										</div>
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<div class="radio">
												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="smart-filter-param-label" for="<?=$ar["CONTROL_ID"] ?>">
													<div class="smart-filter-input-checkbox mb-0 kt-radio<?=$ar["DISABLED"] ? ' disabled' : '' ?>">
														<input
															type="radio"
															value="<?=$ar["HTML_VALUE_ALT"] ?>"
															name="<?=$ar["CONTROL_NAME_ALT"] ?>"
															id="<?=$ar["CONTROL_ID"] ?>"
															<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
															onclick="smartFilter.click(this)"
														/>
														<span></span>
														<div class="smart-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
														if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
															?>&nbsp;(<a data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]; ?></a>)<?
														endif;?></div>
													</div>
												</label>
											</div>
										<?endforeach;?>
									</div>
									<div class="w-100"></div>
									<?
									break;

								//endregion

								//region CALENDAR
								case "U":
									?>
									<div class="col">
										<div class=""><div class="smart-filter-input-container smart-filter-calendar-container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
										<div class=""><div class="smart-filter-input-container smart-filter-calendar-container">
											<?$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'FORM_NAME' => $arResult["FILTER_NAME"] . "_form",
													'SHOW_INPUT' => 'Y',
													'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="' . FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]) . '" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
													'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
													'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
													'SHOW_TIME' => 'N',
													'HIDE_TIMEBAR' => 'Y',
												),
												null,
												array('HIDE_ICONS' => 'Y')
											);?>
										</div></div>
									</div>
									<div class="w-100"></div>
									<?
									break;
								//endregion

								//region CHECKBOXES +
								default:
									?>
								<div class="smart-filter-input-group-checkbox-list">
										<?foreach($arItem["VALUES"] as $val => $ar):?>
											<div class="form-group mb-1">
												<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="smart-filter-checkbox-text form-check-label kt-checkbox mb-0" for="<?=$ar["CONTROL_ID"] ?>">
													<input
														type="checkbox"
														value="<?=$ar["HTML_VALUE"] ?>"
														name="<?=$ar["CONTROL_NAME"] ?>"
														id="<?=$ar["CONTROL_ID"] ?>"
														<?=$ar["CHECKED"] ? 'checked="checked"' : '' ?>
														<?=$ar["DISABLED"] ? 'disabled' : '' ?>
														onclick="smartFilter.click(this)"
													/>
													<?=$ar["VALUE"];
													if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
														?>&nbsp;(<a data-role="count_<?=$ar["CONTROL_ID"]?>"><?=$ar["ELEMENT_COUNT"]; ?></a>)<?
													endif;?>
													<span></span>
												</label>
											</div>
										<?endforeach;?>
								</div>
									<?php
								//endregion
							}
							?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div><!--//row-->

			<div class="row">
				<div class="col smart-filter-button-box">
					<div class="smart-filter-block">
						<div class="smart-filter-parameters-box-container">
							<input
								class="btn btn-primary"
								type="submit"
								id="set_filter"
								name="set_filter"
								value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
							/>
							<input
								class=" btn btn-default"
								type="submit"
								id="del_filter"
								name="del_filter"
								value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
							/>
							<div class="smart-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
								<?=GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>'));?>
								<span class="arrow"></span>
								<br/>
								<a href="<?=$arResult["FILTER_URL"]?>" target=""><?=GetMessage("CT_BCSF_FILTER_SHOW")?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
</div>
	<?php
})->collapsible($collapseId, Portlet\Body::COLLAPSE);

$portlet->render();
?>

<script type="text/javascript">
	var smartFilter = new JCSmartFilter('<?=CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>