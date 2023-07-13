<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>
			</div>
			<div class="kt-grid__item">
				<div class="kt-login-v2__footer">
					<div class="kt-login-v2__link">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR . "include/menu.footer.php",
								"EDIT_TEMPLATE" => ""
							),
							false
						);?>
					</div>

					<div class="kt-login-v2__info">
						<?php include 'footer/copyright.php'; ?>
					</div>			
				</div>
			</div>
		</div>
	</div>

	<script>
	<?php $validatorMessages = \Bitrix\Main\Localization\Loc::loadLanguageFile(__DIR__ . '/../validator.php'); ?>
	if ((window.$ || {}).validator)
	{
		$.extend( $.validator.messages, {
			required: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_REQUIRED'])?>',
			remote: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_REMOTE'])?>',
			email: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_EMAIL'])?>',
			url: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_URL'])?>',
			date: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_DATE'])?>',
			dateISO: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_DATE_ISO'])?>',
			number: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_NUMBER'])?>',
			digits: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_DIGITS'])?>',
			creditcard: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_CREDITCARD'])?>',
			equalTo: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_EQUAL_TO'])?>',
			extension: '<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_EXTENSION'])?>',
			maxlength: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_MAXLENGTH'])?>"),
			minlength: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_MINLENGTH'])?>"),
			rangelength: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_RANGELENGTH'])?>"),
			range: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_RANGE'])?>"),
			max: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_MAX'])?>"),
			min: $.validator.format("<?=CUtil::JSEscape($validatorMessages['RS_B2B_VALIDATOR_MIN'])?>")
		});
	}
	</script>

<?$APPLICATION->IncludeFile(
	SITE_DIR . "include/auth_body_end.php",
	array(),
	array('MODE' => 'html')
);?>
</body>
</html>
<?php

CMain::FinalActions();
die();
