<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

Loc::loadMessages(__FILE__);

?>

<?=date('Y');?>&nbsp;&copy;&nbsp;<a href="https://alfab2b.ru/" target="_blank" class="kt-link" rel="nofollow"><?=Loc::getMessage('RS_B2BPORTAL_FOOTER_COPYRIGHT_DEV')?></a>
