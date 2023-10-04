<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?
global $USER;
if (!$USER->isAuthorized()) {die;}

$post = $_POST;

$db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$post['PROFILE_ID']));
    
while ($arPropVals = $db_propVals->Fetch()){
    $userProfileOrder[$arPropVals['PROP_CODE']] = $arPropVals;
}

$respons = "";

if (!empty($userProfileOrder['PDZ']['VALUE'])) {
    $respons = "<span>ПДЗ: " . $userProfileOrder['PDZ']['VALUE'] . "₽</span>";
}

if (!empty($userProfileOrder['DZ']['VALUE'])) {
    $respons .= "<span style='margin-left: 20px;'>ДЗ: " . $userProfileOrder['DZ']['VALUE'] . "₽</span>";
}

echo $respons;