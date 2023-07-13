<?php
define('NEED_AUTH', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>
<script>
	<?if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0 && preg_match('#^/\w#', $_REQUEST["backurl"])):?>
	document.location.href = "<?=CUtil::JSEscape($_REQUEST["backurl"])?>";
	<?endif?>
</script>
 <p class="mb-0">
	Благодарим за авторизацию на нашем портале.<br>
	Теперь на можете перейти к просмотру <a href="#SITE_DIR#">портала</a>.
</p>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>