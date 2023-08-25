<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignB2BPortalBasketImports $component
 * @var array $arParams
 * @var array $arResult
 * @var array $templateFolder
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$this->addExternalJs(SITE_TEMPLATE_PATH . '/assets/vendors/vue/vue.js');
$this->addExternalJS($templateFolder . '/js/CodesImport.js');
$this->addExternalJS($templateFolder . '/js/FileImport.js');

$sBlockId = 'basketimports_' . $this->randString(5);
?>

<div class="dropdown dropdown-inline">
	<a class="btn btn-default dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
		<?=Loc::getMessage('RS_B2BPORTAL_BI_SELECT_TYPE');?>
	</a>
	<div class="dropdown-menu" x-placement="bottom-end">
		<ul class="kt-nav">
			<li class="kt-nav__item">
				<a href="#" class="kt-nav__link" data-toggle="modal" data-target="#<?=$sBlockId?>_fileModal">
					<i class="kt-nav__link-icon flaticon2-medical-records"></i>
					<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_BI_TYPE_FILE')?></span>
				</a>
			</li>
			<li class="kt-nav__item">
				<a href="#" class="kt-nav__link" data-toggle="modal" data-target="#<?=$sBlockId?>_codesModal">
				<i class="kt-nav__link-icon flaticon2-list-2"></i>
					<span class="kt-nav__link-text"><?=Loc::getMessage('RS_B2BPORTAL_BI_TYPE_CATALOG')?></span>
				</a>
			</li>
		</ul>
	</div>
</div>

<div class="modal fade" id="<?=$sBlockId?>_codesModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=Loc::getMessage('RS_B2BPORTAL_BI_TYPE_CATALOG_TITLE')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">?</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="<?=$sBlockId?>_codes">

                </div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="<?=$sBlockId?>_fileModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=Loc::getMessage('RS_B2BPORTAL_BI_TYPE_FILE_TITLE')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">?</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="<?=$sBlockId?>_file"></div>
			</div>
		</div>
	</div>
</div>



<script>
<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
BX.message(<?=CUtil::PhpToJSObject($messages)?>);


new B2BPortal.Components.BasketCodesImport({
	el: document.getElementById('<?=$sBlockId?>_codes'),
	signedParameters: '<?=$this->getComponent()->getSignedParameters()?>'
});

new B2BPortal.Components.BasketFileImport({
	el: document.getElementById('<?=$sBlockId?>_file'),
	modal: document.getElementById('<?=$sBlockId?>_fileModal'),
	signedParameters: '<?=$this->getComponent()->getSignedParameters()?>'
});
</script>