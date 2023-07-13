<?php

use Bitrix\Main\Localization\Loc;

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

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(mb_strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
<div class="kt-quick-search kt-quick-search--inline kt-quick-search--result-compact" id="<?=$CONTAINER_ID?>">
	<form method="get" class="kt-quick-search__form" action="<?=$arResult["FORM_ACTION"]?>">
		<div class="input-group">
			<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
			<input type="text" class="form-control kt-quick-search__input" autocomplete="off" placeholder="<?=Loc::getMessage('CT_BST_SEARCH_BUTTON');?>" id="<?=$INPUT_ID?>" name="q">
			<div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close" style="display: none;"></i></span></div>
		</div>
	</form>
</div>
<?endif?>

<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?=CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?=$CONTAINER_ID?>',
			'INPUT_ID': '<?=$INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>
