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


$this->addExternalJS($templateFolder . '/script.js');
$this->addExternalCss($templateFolder . '/style.css');

if (!empty($arResult["TICKET"]))
{
	?>
	<div class="row" data-sticky-container>
		<div class="col-12 col-xl-3 order-2">
			<?php
			include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/ticket.php';
			?>
		</div>
		<div class="col-12 col-xl-9 order-1">
			<?php
			include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/messages.php';
			include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/add_message.php';
			?>
		</div>
	</div>
	<?php
}
else
{
	include $_SERVER['DOCUMENT_ROOT'] . $templateFolder . '/add_message.php';
}
