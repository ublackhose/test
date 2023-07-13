<?php

use Bitrix\Main\Localization\loc;

/**
 * @var CMain $APPLICATION
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

?>

<form class="kt-form" method="post" action="<?=$arResult["AUTH_URL"]?>" name="regform">

    <input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult['SIGNED_DATA'])?>" />

    <div class="form-group row">
        <div class="col-lg-6">
            <label><?=Loc::getMessage('main_register_sms_code')?></label>
            <input type="text" name="SMS_CODE" maxlength="50" class="form-control" value="<?=$arResult["SMS_CODE"]?>" autocomplete="off" placeholder="">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <button type="submit" class="btn btn-brand btn-elevate btn-pill kt-login-v2__submit-button" name="code_submit_button" data-tabs="next"><?=Loc::getMessage('RS.B2BPORTAL.REGISTRATION_FORM.BUTTONS.SEND')?></button>
        </div>
    </div>

</form>

<script>
new BX.PhoneAuth({
    containerId: 'bx_register_resend',
    errorContainerId: 'bx_register_error',
    interval: <?=$arResult['PHONE_CODE_RESEND_INTERVAL']?>,
    data: <?=CUtil::PhpToJSObject(['signedData' => $arResult["SIGNED_DATA"],])?>,
    onError: function(response)
    {
        var errorDiv = BX('bx_register_error');
        var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
        errorNode.innerHTML = '';
        for(var i = 0; i < response.errors.length; i++)
        {
            errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
        }
        errorDiv.style.display = '';
    }
});
</script>

<div id="bx_register_error" style="display:none">
    <div class="form-group form-group-last">
        <div class="alert alert-danger" role="alert">
            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
            <div class="alert-text errortext"><?ShowError("error")?></div>
        </div>
    </div>
</div>

<div id="bx_register_resend"></div>
