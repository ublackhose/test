<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CUser $USER
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateName
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


if (!class_exists('Dompdf\Dompdf')) {
	require $_SERVER['DOCUMENT_ROOT'] . getLocalPath('modules/redsign.b2bportal/external/dompdf/autoload.inc.php');
}

/** @var string */
$cartName = Loc::getMessage('RS_B2BPORTAL_SBB_TITLE') ?: '';

if (Loader::includeModule('redsign.vbasket')) {
	/** @var \Redsign\VBasket\Repository\BasketRepository $basketRepository */
	$basketRepository = \Redsign\VBasket\Core::container()->get('basket_repository');

	/** @var \Redsign\VBasket\Context $context */
	$context = \Redsign\VBasket\Core::container()->get('context');

	/** @var \Redsign\VBasket\Basket|null $basket */
	$basket = $basketRepository->getByCodeWithContext(
		\Redsign\VBasket\BasketHelper::getCurrentBasketCode(),
		$context
	);

	if ($basket) {
		$cartName = (string)$basket->getName();
	}
}

$isDesignMode = $APPLICATION->GetShowIncludeAreas() && $USER->IsAdmin();

if (!$isDesignMode) {
	$APPLICATION->RestartBuffer();

	$styles = '
		body{
			font-family: "Dejavu Sans", Arial, Helvetica, sans-serif;
			font-size: 13px;
			margin: 0;
			padding: 0;
			-webkit-text-size-adjust: none !important;
			width: 100%;
			color: #646c9a;
		}
		a {
			color: #5867dd;
			text-decoration: none;
		}
	';

	$styles .= file_get_contents($_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/style.css');

	ob_start();
	?><!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title><?=$cartName?></title>
		<style><?=$styles?></style>
	</head>
	<body>
	<?php
} else {
	?><div class="bg-white p-3"><?
}

?>
<table class="pdf-cart-header">
	<td class="pdf-cart-header__logo">
		<a href="<?=$arResult['HOST']?>">
			<?$APPLICATION->IncludeFile(
				SITE_DIR . "include/logo_colors.php",
				array(),
				array('NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_INCLUDE_AREA_LOGO'), 'MODE' => 'html')
			);?>
		</a>
	</td>
	<td class="pdf-cart-header__contacts">
		<?$APPLICATION->IncludeFile(
			SITE_DIR . "include/pdf_contacts.php",
			array(),
			array('NAME' => Loc::getMessage('RS_B2BPORTAL_SBB_INCLUDE_AREA_CONTACTS'), 'MODE' => 'html')
		);?>
	</td>
</table>

<h2><?=Loc::getMessage('RS_B2BPORTAL_SBB_TITLE');?></h2>
<?php

if (count($arResult['ROWS']) > 0)
{
	?>
	<table class="pdf-cart-table">
		<thead>
			<tr>
			<?php
			foreach ($arResult['COLUMNS'] as $column) {
				echo '<th class="' . $column['field'] . '">' . $column['label'] . '</th>';
			}
			?></tr>
		</thead>
		<tbody>
		<?php foreach($arResult['ROWS'] as $row): ?>
			<tr>
			<?php foreach($arResult['COLUMNS'] as $column): ?>
				<td class="<?=$column['field']?>">
					<?php
					switch($column['field']):
						case 'name':
							?>
							<div>
								<a href="<?=$row['URL']?>"><?=$row['NAME']?></a>
							</div>
							<div>
								<?php if (isset($row['ARTICLE']) && strlen($row['ARTICLE']) > 0): ?>
									<span><?=Loc::getMessage('RS_B2BPORTAL_SBB_ARTICLE');?>: <?=$row['ARTICLE']?></span>
								<?php endif; ?>
							</div>
							<?
							break;

						case 'price':
							echo $row['PRICE_FORMATTED'];
							break;

						case 'sum_price':
							echo $row['SUM_PRICE_FORMATTED'];
							break;

						default:
							$field = strtoupper($column['field']);
							if (isset($row[$field]))
								echo $row[$field];
					endswitch;
					?>
				</td>
			<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<br><br>
	<hr class="pdf-cart-delimiter">
	<table class="pdf-total-table">
		<tbody>
			<tr>
				<td><b><?=Loc::getMessage('RS_B2BPORTAL_SBB_TOTAL_NAME')?></b></td>
				<td><?=$arResult['SUMMARY']['count']?></td>
			</tr>
			<tr>
				<td><b><?=Loc::getMessage('RS_B2BPORTAL_SBB_TOTAL_SUM')?></b></td>
				<td ><?=$arResult['SUMMARY']['allSum_FORMATED']?></td>
			</tr>
		</tbody>
	</table>

	<?php
} else {
	?><p><?=Loc::getMessage('RS_B2BPORTAL_SBB_EMPTY');?></p><?
}


if (!$isDesignMode) {
	?>
	</body></html>
	<?php

	/** @var string */
	$html = ob_get_clean() ?: '';
	$html = preg_replace('/(src=\")(.*?)\"/i', 'src="' . $_SERVER['DOCUMENT_ROOT'] . '$2"', $html) ?: '';
	if ('utf-8' != strtolower(SITE_CHARSET))
	{
		$html = mb_convert_encoding($html, 'UTF-8', SITE_CHARSET);
		$cartName = mb_convert_encoding($cartName, 'UTF-8', SITE_CHARSET);
	}

	$pdf = new Dompdf\Dompdf();
	$pdf->setPaper('A4', 'portrait');
	$pdf->set_option('isHtml5ParserEnabled', true);

	$pdf->loadHtml($html);

	$pdf->render();
	$pdf->stream($cartName . '.pdf', []);

	die();
} else {
	?>
	</div>
	<?php
}
