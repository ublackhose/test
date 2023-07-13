<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignKompredOfferShow $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!empty($arResult['ERRORS']))
{
	if (isset($arResult['ERRORS'][$component::ERROR_NO_ACCESS]))
	{
		$APPLICATION->AuthForm($arResult['ERRORS'][$component::ERROR_NO_ACCESS], false, false, 'N', false);
	}
	else
	{
		echo '<div class="alert alert-danger">' .
			implode('<br>', $arResult['ERRORS']) .
		'</div>';
	}
}
elseif (isset($arResult['STRUCTURE']['blocks']))
{
	$sanitizer = new \CBXSanitizer();
	$sanitizer->AddTags([
		'a' => ['href'],
		'br' => [],
		'b' => [],
		'i' => []
	]);

	if (!class_exists('Dompdf\Dompdf'))
		require __DIR__ . '/dompdf/autoload.inc.php';

	global $APPLICATION;
	$APPLICATION->RestartBuffer();

	ob_start();

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title><?=$arResult['OFFER']['NAME']?></title>
		<style>
			<?=file_get_contents($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/style_pdf.css');?>
		</style>
	</head>
	<body>
		<?php
		foreach ($arResult['STRUCTURE']['blocks'] as ['type' => $type, 'data' => $data])
		{
			switch($type)
			{
				case 'paragraph':
					?><p><?=$data['text']?></p><?php
					break;
				case 'header':
					$level = $data['level'];
					$text = $data['text']
					?><h<?=$level?> class="heading"><?=$text?></h<?=$level?>><?php
					break;
				case 'templateHeader':
					?><table class="rskp-pdf-header">
							<tr>
								<td class="rskp-pdf-header__logo">
									<?php
									$imagePath = $_SERVER['DOCUMENT_ROOT'] . $data['logo'];
									if (file_exists($imagePath))
									{
										?><img src="data:image/png;base64,<?=base64_encode(file_get_contents($imagePath))?>" title="logo"><?php
									}
									?>
								</td>
								<td class="rskp-pdf-header__contacts">
									<?=$sanitizer->SanitizeHtml($data['contacts'])?>
								</td>
							</tr>
					</table><?php
					break;
				case 'productTable':
					?><table class="rskp-pdf-pt">
						<thead>
							<tr>
								<th class="rskp-pdf-pt__col rskp-pdf-pt__col--name">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_COL_NAME')?>
								</th>
								<th class="rskp-pdf-pt__col rskp-pdf-pt__col--price">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_COL_PRICE')?>
								</th>
								<th class="rskp-pdf-pt__col rskp-pdf-pt__col--quantity">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_COL_QUANTITY')?>
								</th>
								<th class="rskp-pdf-pt__col rskp-pdf-pt__col--sum">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_COL_SUM')?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($arResult['OFFER']['PRODUCTS'] as $productData): ?>
								<tr>
									<td class="rskp-pdf-pt__col rskp-pdf-pt__col--name">
										<div class="rskp-pdf-pt__name"><?=$productData['NAME']?></div>
										<?php if (!empty($productData['VENDOR_CODE'])): ?>
											<div class="rskp-pdf-pt__code">
												<small><?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_VENDOR_CODE')?> <?=$productData['VENDOR_CODE']?></small>
											</div>
										<?php endif; ?>
									</td>
									<td class="rskp-pdf-pt__col rskp-pdf-pt__col--price">
										<?=$productData['PRICE_FORMATTED']?>
									</td>
									<td class="rskp-pdf-pt__col rskp-pdf-pt__col--quantity">
										<?=$productData['QUANTITY']?> <?=$productData['MEASURE_NAME']?>
									</td>
									<td class="rskp-pdf-pt__col rskp-pdf-pt__col--sum">
										<?=$productData['SUM_PRICE_FORMATTED']?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3" class="rskp-pdf-pt__col rskp-pdf-pt__col--total">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_SUMMARY_COUNT')?>
								</td>
								<td class="rskp-pdf-pt__col rskp-pdf-pt__col--sum">
									<?=count($arResult['OFFER']['PRODUCTS'])?>
								</td>
							</tr>
							<tr>
								<td colspan="3" class="rskp-pdf-pt__col rskp-pdf-pt__col--total">
									<?=Loc::getMessage('RS_KP_KOS_T_DEFAULT_SUMMARY_TOTAL')?>
								</td>
								<td class="rskp-pdf-pt__col rskp-pdf-pt__col--sum">
									<?=$arResult['OFFER']['TOTAL_PRICE_FORMATTED']?>
								</td>
							</tr>
						</tfoot>
					</table><?php
			}
		}
		?>
	</body>
	</html>
	<?php

	$html = ob_get_clean();

	if ('utf-8' != mb_strtolower(SITE_CHARSET))
	{
		$html = mb_convert_encoding($html, 'UTF-8', SITE_CHARSET);
	}

	$options = new Dompdf\Options();
	$options->set('rootDir', $_SERVER['DOCUMENT_ROOT']);
	$options->set('isHtml5ParserEnabled');
	$options->set('isRemoteEnabled', true);

	$pdf = new Dompdf\Dompdf($options);
	$pdf->setPaper('A4', 'portait');

	$pdf->loadHtml($html);

	$pdf->render();
	$pdf->stream('offer_' . $arResult['OFFER']['ID'] . '.pdf', 0);

	die();
}