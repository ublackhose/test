<?
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
// AddEventHandler("main", "OnBeforeUserLogin", Array("CUserEx", "onBeforeUserLogin"));
AddEventHandler("main", "OnBeforeUserRegister", Array("CUserEx", "deactivateUser"));
// AddEventHandler("main", "OnAfterUserRegister", Array("CUserEx", "sendUserToCrm"));
// AddEventHandler("main", "OnAfterUserAuthorize", Array("CUserEx", "openMainAfterAuth"));
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

require_once __DIR__ . '/crm_import/crest.php';


/* Смена статуса заказа на проверку менеджера при изменении способа оплаты начало*/


AddEventHandler("sale", "OnBeforeOrderUpdate", "checkOrder");
function checkOrder($id,$arFields){

    $dbRes = \Bitrix\Sale\PaymentCollection::getList([
        'select' => ['PAY_SYSTEM_ID'],
        'filter' => [
            '=ORDER_ID' => $id,
        ]
    ]);


    $item = $dbRes->fetch();

    AddMessage2Log($item['PAY_SYSTEM_ID']."===".$arFields['PAY_SYSTEM_ID'], "Test_Pay_System");
    if($item['PAY_SYSTEM_ID'] != $arFields['PAY_SYSTEM_ID']){
        if($arFields['STATUS_ID'] != 'N'){
            CSaleOrder::StatusOrder($id, "N");
        }
    }
}
/* Смена статуса заказа на проверку менеджера при изменении способа оплаты конец*/




/* НАЧАЛО Обработчик при оформлении заказа НАЧАЛО*/



AddEventHandler("sale", "OnBeforeOrderAdd", "addOrderToList");

function addOrderToList($arFields){


    if($arFields =){

    }
    AddMessage2Log($arFields, "addOrderToList");

}



/* КОНЕЦ Обработчик при оформлении заказа КОНЕЦ*/



function sendUserToCrm($arFields) {
    $string = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . "/confirmUser/?userLogin=" . $arFields['LOGIN'];

    $data = [
        'TITLE' => 'Регистрация нового пользователя на сайте',
        'SOURCE_ID' => 3,
        'NAME' => $arFields['NAME'],
        'PHONE' => array(
            'n0' => array(
                'VALUE' =>  $arFields['PHONE_NUMBER'],
                'VALUE_TYPE' => 'MOBILE',
            ),
        ),
        'COMMENTS' => 'ТЕСТ. Для активации пользователя перейдите по <a href="'.$string.'">ссылке</a>',
        'ASSIGNED_BY_ID' => 6391,
        'UF_CRM_1688103617380' => $arFields['LOGIN'], // (ДАННЫЕ ДЛЯ АВТОРИЗАЦИИ) Логин
        'UF_CRM_1688104526391' => $arFields['NAME'] . ' ' . $arFields['LAST_NAME'], // (ДАННЫЕ ДЛЯ АВТОРИЗАЦИИ) ФИО
        'UF_CRM_1688103927034' => $arFields['EMAIL'], // (ДАННЫЕ ДЛЯ АВТОРИЗАЦИИ) E-mail
    ];

    $personType = [
        1 => 'Физическое лицо',
        2 => 'Юридическое лицо',
    ];

    $props = [
        1 => 'UF_CRM_1688104643675', // (ФИЗИЧЕСКОЕ ЛИЦО. ЛИЧНЫЕ ДАННЫЕ) ФИО
        2 => 'UF_CRM_1688104661687', // (ФИЗИЧЕСКОЕ ЛИЦО. ЛИЧНЫЕ ДАННЫЕ) E-mail
        3 => 'UF_CRM_1688104682447', // (ФИЗИЧЕСКОЕ ЛИЦО. ЛИЧНЫЕ ДАННЫЕ) Телефон
        7 => 'UF_CRM_1688104746393', // (ФИЗИЧЕСКОЕ ЛИЦО. ЛИЧНЫЕ ДАННЫЕ) Адрес доставки
    
        8 => 'UF_CRM_1688104793493', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) Наименование организации
        20 => 'UF_CRM_1689061781159', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) Направление деятельности компании
        22 => 'UF_CRM_1689061823844', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) Должность
        23 => 'UF_CRM_1689062834871', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) Есть сайт
        10 => 'UF_CRM_1689063809839', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) ИНН
        11 => 'UF_CRM_1689063818577', // (ЮР. ЛИЦО. ДАННЫЕ О КОМПАНИИ) КПП
    
        14 => 'UF_CRM_1689062929363', // (ЮР. ЛИЦО. КОНТАКТНАЯ ИНФОРМАЦИЯ) Телефон
        19 => 'UF_CRM_1689062953837', // (ЮР. ЛИЦО. КОНТАКТНАЯ ИНФОРМАЦИЯ) Адрес доставки
        25 => 'UF_CRM_1689063827973', // (ЮР. ЛИЦО. КОНТАКТНАЯ ИНФОРМАЦИЯ) Имя
        24 => 'UF_CRM_1689063839369', // (ЮР. ЛИЦО. КОНТАКТНАЯ ИНФОРМАЦИЯ) Фамилия
        26 => 'UF_CRM_1689063856950', // (ЮР. ЛИЦО. КОНТАКТНАЯ ИНФОРМАЦИЯ) Отчество
    ];


    $query = new \Bitrix\Main\Entity\Query(Bitrix\Sale\Internals\UserPropsTable::getEntity());
    $profile = $query
        ->setSelect(array("ID", "NAME", "PERSON_TYPE_ID"))
        ->setFilter(array("USER_ID" => $arFields['USER_ID']))
        ->exec()
        ->fetch();

    $query = new \Bitrix\Main\Entity\Query(Bitrix\Sale\Internals\UserPropsValueTable::getEntity());
    $profileProps = $query
        ->setSelect(array("ID", "NAME", "VALUE", "USER_PROPS_ID", "ORDER_PROPS_ID"))
        ->setFilter(array("USER_PROPS_ID" => $profile['ID']))
        ->exec()
        ->fetchAll();

    $data['UF_CRM_1688104595621'] = $profile['PERSON_TYPE_ID']; // физ или юр лицо
    $data['UF_CRM_1688104547987'] = $profile['NAME']; // название профиля

    foreach ($profileProps as $key => $prop) {
        if (isset($props[$prop["ORDER_PROPS_ID"]])) {
            $data[$props[$prop["ORDER_PROPS_ID"]]] = $prop["VALUE"];
        }
    }

    $result = CRest::call(
    'crm.lead.add',
    [
        'fields' => $data
    ]);

    return $data;
}

class CUserEx
{
    static function onBeforeUserLogin ($arFields)
    {
		// file_get_contents('user1.log', print_r($arFields,1));
        $filter = Array("EMAIL" => $arFields["LOGIN"]);
        $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
        if ($user = $rsUsers->GetNext())
            $arFields["LOGIN"] = $user["LOGIN"];
        /* else $arFields["LOGIN"] = ""; */
    }

    static function deactivateUser (&$arFields)
    {
        $arFields['ACTIVE'] = 'N';
        return true;
    }

    static function openMainAfterAuth ($arUser)
    {
		// if( если в группе для 1С ) //todo Намутить группу для 1С 
		//file_get_contents('user2.log', print_r($arUser,1));
        //LocalRedirect('/');
    }
}
?>