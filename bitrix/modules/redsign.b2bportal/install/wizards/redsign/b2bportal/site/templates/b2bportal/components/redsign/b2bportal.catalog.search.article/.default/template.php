<?php

use Bitrix\Main\Localization\Loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var RedsignB2BPortalCatalogSearchArticle $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();


$this->addExternalJS($templateFolder . '/js/component.js');

$sBlockId = 'searchArticle_' . $this->randString(5);

?>
<div id="<?=$sBlockId?>"></div>
<script>
<?php $messages = Loc::loadLanguageFile(__FILE__); ?>
BX.message(<?=CUtil::PhpToJSObject($messages)?>);

new B2BPortal.Components.CatalogSearchArticle(
	document.getElementById('<?=$sBlockId?>'),
	{
		signedParameters: '<?=$this->getComponent()->getSignedParameters()?>'
	}
);
</script>
