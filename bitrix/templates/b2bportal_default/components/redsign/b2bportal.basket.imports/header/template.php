<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignB2BPortalBasketImports $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();




$this->addExternalJs(SITE_TEMPLATE_PATH . '/assets/vendors/vue/vue.js');
$this->addExternalJS($templateFolder . '/js/CodesImport.js');
$this->addExternalJS($templateFolder . '/js/FileImport.js');

$sBlockId = 'basket_' . $this->randString(5);
?>



<div class="header-download">
	<div class="header-download-btn btn btn-default" aria-expanded="false" data-toggle="modal" data-target="#<?=$sBlockId?>_fileModalHead">
		<i class="kt-nav__link-icon flaticon2-medical-records"></i>
		<span class="kt-nav__link-text"><?=Loc::getMessage('HEADER_RS_B2BPORTAL_BI_TITLE')?></span>
	</div>
</div>

<div class="modal fade" id="<?=$sBlockId?>_codesModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=Loc::getMessage('HEADER_RS_B2BPORTAL_BI_TITLE')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">?</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="<?=$sBlockId?>_codes"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="<?=$sBlockId?>_fileModalHead">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=Loc::getMessage('HEADER_RS_B2BPORTAL_BI_TITLE')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">?</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="<?=$sBlockId?>_fileHead"></div>
			</div>
		</div>
	</div>
</div>



<script>
<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
BX.message(<?=CUtil::PhpToJSObject($messages)?>);

new B2BPortal.Components.BasketCodesImport({
	el: document.getElementById('<?=$sBlockId?>_codesHead'),
	signedParameters: '<?=$this->getComponent()->getSignedParameters()?>'
});

new B2BPortal.Components.BasketFileImport({
	el: document.getElementById('<?=$sBlockId?>_fileHead'),
	modal: document.getElementById('<?=$sBlockId?>_fileModalHead'),
	signedParameters: '<?=$this->getComponent()->getSignedParameters()?>'
});


</script>





