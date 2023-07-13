<?php

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


$blockId = 'tickets_' . $this->randString(5);
$collapsibleId = $blockId . '_collpasible';

$portlet = new Portlet();

$portlet->head(new Portlet\Head(function () use ($collapsibleId) {

	/** @var Portlet\Head $this */
	$this->title('Список обращений');

	$this->toolbar(function () use ($collapsibleId) {

		echo <<<EOL
			<a href="#{$collapsibleId}" class="btn btn-default btn-bold btn-upper btn-font-sm" data-toggle="collapse">
				<i class="fa fa-angle-down pr-0"></i>
			</a>
EOL;
	});
}));

$body = $portlet->body(function () {
});

$body->collapsible($collapsibleId, Portlet\Body::COLLAPSE);

$portlet->render();

unset($portlet);
