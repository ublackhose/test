<?php


/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->setFrameMode(true);

if (!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
	{
		?><ul class="kt-pagination__links"></ul><?php
		return;
	}
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>
<ul class="kt-pagination__links">
	<?php
	if ($arResult["bDescPageNumbering"] === true)
	{
		if ($arResult['NavPageNomer'] < $arResult['NavPageCount'])
		{
			if ($arResult['bSavePage'])
			{
				?>
				<li class="kt-pagination__link--first">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<li class="kt-pagination__link--prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] + 1)?>">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
				<?php
			}
			else
			{
				?>
				<li class="kt-pagination__link--first">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<?php
				if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1))
				{
					?>
					<li class="kt-pagination__link--prev">
						<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
							<i class="fa fa-angle-left"></i>
						</a>
					</li>
					<?php
				}
				else
				{
					?>
					<li class="kt-pagination__link--prev">
						<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] + 1)?>">
							<i class="fa fa-angle-left"></i>
						</a>
					</li>
					<?php
				}
			}
		}
		else
		{
			?>
			<li class="kt-pagination__link--first">
				<a>
					<i class="fa fa-angle-double-left"></i>
				</a>
			</li>
			<li class="kt-pagination__link--prev">
				<a>
					<i class="fa fa-angle-left"></i>
				</a>
			</li>
			<?php
		}

		while ($arResult['nStartPage'] >= $arResult['nEndPage'])
		{
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"])
			{
				?>
				<li class="kt-pagination__link--active">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<?=$arResult["NavPageCount"] - $arResult["nStartPage"] + 1?>
					</a>
				</li>
				<?php
			}
			elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false)
			{
				?>
				<li>
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<?=$arResult["NavPageCount"] - $arResult["nStartPage"] + 1?>
					</a>
				</li>
				<?php
			}
			else
			{
				?>
				<li>
					<a href="<?=$arResult['sUrlPath']?>?<?=$strNavQueryString?>PAGEN_<?=$arResult['NavNum']?>=<?=$arResult['nStartPage']?>">
						<?=$arResult['NavPageCount'] - $arResult['nStartPage'] + 1?>
					</a>
				</li>
				<?php
			}

			$arResult['nStartPage']--;
		}

		if ($arResult['NavPageNomer'] > 1)
		{
			?>
			<li class="kt-pagination__link--next">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] - 1)?>">
					<i class="fa fa-angle-right"></i>
				</a>
			</li>
			<li class="kt-pagination__link--last">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
					<i class="fa fa-angle-double-right"></i>
				</a>
			</li>
			<?php
		}
		else
		{
			?>
			<li class="kt-pagination__link--next kt-pagination__link--disabled">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] - 1)?>">
					<i class="fa fa-angle-right"></i>
				</a>
			</li>
			<li class="kt-pagination__link--last kt-pagination__link--disabled">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
					<i class="fa fa-angle-double-right"></i>
				</a>
			</li>
			<?php
		}
	}
	else
	{
		if ($arResult["NavPageNomer"] > 1)
		{
			if ($arResult['bSavePage'])
			{
				?>
				<li class="kt-pagination__link--first">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<li class="kt-pagination__link--prev">
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] - 1)?>">
						<i class="fa fa-angle-left"></i>
					</a>
				</li>
				<?php
			}
			else
			{
				?>
				<li class="kt-pagination__link--first">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<i class="fa fa-angle-double-left"></i>
					</a>
				</li>
				<?php
				if ($arResult["NavPageNomer"] > 2)
				{
					?>
					<li class="kt-pagination__link--prev">
						<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] - 1)?>">
							<i class="fa fa-angle-left"></i>
						</a>
					</li>
					<?php
				}
				else
				{
					?>
					<li class="kt-pagination__link--prev">
						<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
							<i class="fa fa-angle-left"></i>
						</a>
					</li>
					<?php
				}
			}
		}
		else
		{
			?>
			<li class="kt-pagination__link--first kt-pagination__link--disabled">
				<a>
					<i class="fa fa-angle-double-left"></i>
				</a>
			</li>
			<li class="kt-pagination__link--prev kt-pagination__link--disabled">
				<a>
					<i class="fa fa-angle-left"></i>
				</a>
			</li>
			<?php
		}

		while ($arResult['nStartPage'] <= $arResult['nEndPage'])
		{
			if ($arResult["nStartPage"] == $arResult["NavPageNomer"])
			{
				?>
				<li class="kt-pagination__link--active">
					<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
						<?=$arResult["nStartPage"]?>
					</a>
				</li>
				<?php
			}
			elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false)
			{
				?>
				<li>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
						<?=$arResult["nStartPage"]?>
					</a>
				</li>
				<?php
			}
			else
			{
				?>
				<li>
					<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>">
						<?=$arResult["nStartPage"]?>
					</a>
				</li>
				<?php
			}

			$arResult['nStartPage']++;
		}

		if ($arResult['NavPageNomer'] < $arResult['NavPageCount'])
		{
			?>
			<li class="kt-pagination__link--next">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"] + 1)?>">
					<i class="fa fa-angle-right"></i>
				</a>
			</li>
			<li class="kt-pagination__link--last">
				<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
					<i class="fa fa-angle-double-right"></i>
				</a>
			</li>
			<?php
		}
		else
		{
			?>
			<li class="kt-pagination__link--next kt-pagination__link--disabled">
				<a>
					<i class="fa fa-angle-right"></i>
				</a>
			</li>
			<li class="kt-pagination__link--last kt-pagination__link--disabled">
				<a>
					<i class="fa fa-angle-double-right"></i>
				</a>
			</li>
			<?php
		}
	}
	?>
</ul>