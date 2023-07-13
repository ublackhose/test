<?php

use Bitrix\Main\Localization\Loc;
use Redsign\B2BPortal\UI\Portlet;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalCss(SITE_TEMPLATE_PATH . '/assets/theme/plugins/custom/jstree/jstree.bundle.css');
$this->addExternalJs(SITE_TEMPLATE_PATH . '/assets/theme/plugins/custom/jstree/jstree.bundle.js');
$this->addExternalJS($templateFolder . '/js/component.js');

$blockId = 'csl_' . $this->randString(5);

$portlet = new Portlet($blockId);

$portlet->head(new Portlet\Head(function () {
	/** @var Portlet\Head $this */
	$this->title(Loc::getMessage('RS_B2B_CSL_TREE_BLOCK_TITLE'));
}));

$portlet->body(function () use ($arResult, $blockId) {
	?>
	<div class="row mb-4">
		<div class="col-9">
			<input id="<?=$blockId?>_search" class="form-control" placeholder="<?=Loc::getMessage('RS_B2B_CSL_TREE_SEARCH')?>">
		</div>
	</div>

	<div id="<?=$blockId?>_tree">
		<?php
		$topDepth = $arResult["SECTION"]["DEPTH_LEVEL"];
		$currentDepth = $topDepth;

		foreach($arResult['SECTIONS'] as $arSection)
		{
			if ($currentDepth < $arSection['DEPTH_LEVEL'])
				echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"] - $topDepth),"<ul>";

			elseif($currentDepth == $arSection['DEPTH_LEVEL'])
				echo '</li>';
			else
			{
				while($currentDepth > $arSection["DEPTH_LEVEL"])
				{
					echo "</li>";
					echo "\n",str_repeat("\t", $currentDepth - $topDepth),"</ul>","\n",str_repeat("\t", $currentDepth - $topDepth - 1);
					$currentDepth--;
				}
			}

			?><li data-section-id="<?=$arSection['ID']?>"><?=$arSection['NAME']?><?php

			$currentDepth = $arSection["DEPTH_LEVEL"];
		}

		while($currentDepth > $topDepth)
		{
			echo "</li>";
			echo "\n",str_repeat("\t", $currentDepth - $topDepth),"</ul>","\n",str_repeat("\t", $currentDepth - $topDepth - 1);
			$currentDepth--;
		}
		?>
	</div>
	<script>
		(function() {
			new B2BPortal.Components.CSLTree({
				treeNode: document.getElementById('<?=$blockId?>_tree'),
				searchInputNode: document.getElementById('<?=$blockId?>_search')
			});
		}());
	</script>
	<?php
});

$portlet->render();
