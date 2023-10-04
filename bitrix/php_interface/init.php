<?

use Bitrix\Sale;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log.txt");
define("SHOW_RATIO_PRICE", 1); // 1 - только RATIO_PRICE, 2 - все выбранные цены + RATIO, 3 - только выбранные 

AddEventHandler("main", "OnBeforeUserLogin", array("CUserEx", "onBeforeUserLogin"));
AddEventHandler("main", "OnBeforeUserRegister", array("CUserEx", "deactivateUser"));
AddEventHandler("main", "OnAfterUserLogout", array("CUserEx", "logoutUser"));
AddEventHandler("main", "OnAfterUserAuthorize", array("CUserEx", "openMainAfterAuth"));

require_once __DIR__ . '/crm_import/crest.php';


/* Set delivery handlers start*/

function addCustomDeliveryServices()
{
    return new \Bitrix\Main\EventResult(
        \Bitrix\Main\EventResult::SUCCESS,
        array(
            '\Sale\Handlers\Delivery\CustomHandler' => '/bitrix/php_interface/include/sale_delivery/handler.php',
            'Sale\Major\LTL\MajorLTL' => '/bitrix/php_interface/include/sale_delivery/major.php'
        )
    );
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'onSaleDeliveryHandlersClassNamesBuildList',
    'addCustomDeliveryServices'
);

/* Set delivery handlers end*/


/* Смена статуса заказа на проверку менеджера при изменении способа оплаты начало*/

AddEventHandler("sale", "OnBeforeOrderUpdate", "checkOrder");
function checkOrder($id, $arFields)
{
    $dbRes = \Bitrix\Sale\PaymentCollection::getList([
        'select' => ['PAY_SYSTEM_ID'],
        'filter' => [
            '=ORDER_ID' => $id,
        ]
    ]);

    $item = $dbRes->fetch();

    if ($item['PAY_SYSTEM_ID'] != $arFields['PAY_SYSTEM_ID']) {
        if ($arFields['STATUS_ID'] != 'N') {
            CSaleOrder::StatusOrder($id, "N");
        }
    }
    if ($arFields['STATUS_ID'] == 'K') {
        $order = \Bitrix\Sale\Order::load($id);
        $propertyCollection = $order->getPropertyCollection();
        $property = $propertyCollection->getItemByOrderPropertyCode("TRACKING_URL");
        $tu = $property->getValue();

        $property = $propertyCollection->getItemByOrderPropertyCode("TRACKING_NUMBER");
        $tn = $property->getValue();

        $orderad = $order->getFields()->getValues();
        if ($tu && $tn) {
            $property = $propertyCollection->getUserEmail();
            $email = $property->getValue();

            $result = \Bitrix\Sale\Delivery\Services\Table::getList(array(
                'filter' => array('ACTIVE' => 'Y', 'ID' => $order->getDeliverySystemId()[0]),
            ));

            if ($delivery = $result->fetch()) {
                $delivery = $delivery['NAME'];
            }

            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/lol.log", $email, 8);
            $strEmail = COption::GetOptionString('main', 'email_from');

            mail(
                $email,
                "Заказ №" . $id . " передан в доставку",
                "Информационное сообщение сайта " . $_SERVER['HTTP_HOST'] . "<br>
 ------------------------------------------<br>
 <br>
 Заказ номер " . $id . " от " . $orderad['DATE_INSERT']->format("d.m.Y") . " передан в доставку." . $delivery . "<br>
 <br>
 Ваш токен:" . $tn . " Ссылка для отслеживания: " . $tu . "
 <br>",
                "From: " . $strEmail . "\r\n" .
                "CC: " . $email . "MIME-Version: 1.0" . "\r\n" . "Content-type:text/html;charset=UTF-8" . "\r\n"
            );

            CSaleOrder::StatusOrder($id, 'D');
        }
    }
}

/* Смена статуса заказа на проверку менеджера при изменении способа оплаты конец*/


/* НАЧАЛО Обработчик при оформлении заказа НАЧАЛО*/

use Bitrix\Main;

Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderSaved',
    'addOrderToList'
);

function addOrderToList(Main\Event $event)
{
    $collection = $event->getParameter("ENTITY")->getShipmentCollection()->getNotSystemItems();
    $isNew = $event->getParameter("IS_NEW");

    if ($isNew) {
        foreach ($collection as $shipment) {
            if ($shipment->getField('DELIVERY_ID') == 2) {
                $shipment->setField('STATUS_ID', 'DT');
            }
        }


        if (CModule::IncludeModule('highloadblock')) {
            $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
            $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
            $strEntityDataClass = $obEntity->getDataClass();
        }

        if (CModule::IncludeModule('highloadblock')) {
            $rsData = $strEntityDataClass::getList(array(
                'select' => array('ID', 'UF_BASKET', 'UF_PRODUCTS'),
                'order' => array('ID' => 'ASC'),
                'limit' => '50',
            ));
            while ($arItem = $rsData->Fetch()) {
                if ($arItem['UF_BASKET'] == Bitrix\Sale\Fuser::getId()) {
                    $par['ID'] = $arItem['ID'];
                    $par['UF_BASKET'] = $arItem['UF_BASKET'];
                    $par['UF_PRODUCTS'] = $arItem['UF_PRODUCTS'];
                }
            }
        }

        $articules = null;
        $pars = json_decode($par['UF_PRODUCTS']);



        foreach ($pars as $item){
            $res_2 = CIBlockElement::GetProperty(5, $item, "sort", "asc", array("CODE" => "CML2_ARTICLE"));
            if($ar_props = $res_2->Fetch())
                $articules[] = $ar_props["VALUE"];
        }


        $order = $event->getParameter("ENTITY");
        $collection = $order->getPropertyCollection();
        $propertyValue = $collection->getItemByOrderPropertyCode('PRODUCTS_NO_PRICE');
        if(is_array($articules)){
            $r = $propertyValue->setField('VALUE', implode(",",$articules));
        }else{
            $r = $propertyValue->setField('VALUE', $articules);
        }




        $arElementFields = array(
            'UF_BASKET' => Bitrix\Sale\Fuser::getId(),
            'UF_PRODUCTS' => ""
        );

        if($arElementFields){
            $obResult = $strEntityDataClass::update($par['ID'], $arElementFields);
        }

        $order->save();
    }
}

/* КОНЕЦ Обработчик при оформлении заказа КОНЕЦ*/


function sendUserToCrm($arFields)
{
    $string = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . "/confirmUser/?userLogin=" . $arFields['LOGIN'];

    $data = [
        'TITLE' => 'Регистрация нового пользователя на сайте',
        'SOURCE_ID' => 3,
        'NAME' => $arFields['NAME'],
        'PHONE' => array(
            'n0' => array(
                'VALUE' => $arFields['PHONE_NUMBER'],
                'VALUE_TYPE' => 'MOBILE',
            ),
        ),
        'COMMENTS' => 'Для активации пользователя перейдите по <a href="' . $string . '">ссылке</a>',
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
        ]
    );

    file_put_contents(__DIR__.'/$result.log', print_r($result, true));

    return $data;
}

class CUserEx
{
    static function onBeforeUserLogin($arFields)
    {
        $filter = array("EMAIL" => $arFields["LOGIN"]);
        $rsUsers = CUser::GetList(($by = "LAST_NAME"), ($order = "asc"), $filter);
        if ($user = $rsUsers->GetNext()) {
            $arFields["LOGIN"] = $user["LOGIN"];
        }
        /* else $arFields["LOGIN"] = ""; */
    }

    static function logoutUser($arFields)
    {
        $groups = CUser::GetUserGroup($arFields['USER_ID']);
        if (!in_array(11, $groups)) {
            LocalRedirect('/auth/');
        }
    }

    static function deactivateUser(&$arFields)
    {
        $arFields['ACTIVE'] = 'N';
        return true;
    }

    static function openMainAfterAuth($arUser)
    {
        $cookie = new Cookie("PDZSHOW", 1);
        $cookie->setHttpOnly(false);
        $cookie->setSecure(false);

        \Bitrix\Main\Context::getCurrent()->getResponse()->addCookie(
            $cookie
        );
        
        $groups = CUser::GetUserGroup($arUser['user_fields']['ID']);
        if (!in_array(11, $groups)) {
            LocalRedirect('/');
        }
    }
}

/* START для отправки пароля на почту пользователю при смене пароля */

\Bitrix\Main\EventManager::getInstance()->addEventHandlerCompatible(
    'main',
    'OnBeforeUserChangePassword',
    'SendPassword::onBeforeUserChangePassword'

);
\Bitrix\Main\EventManager::getInstance()->addEventHandlerCompatible(
    'main',
    'OnBeforeEventAdd',
    'SendPassword::onBeforeEventAdd'
);

class SendPassword
{
    static function onBeforeUserChangePassword($arParams)
    {
        self::singleton(true, $arParams["PASSWORD"]);
    }

    static function onBeforeEventAdd(&$event, &$lid, &$arFields, &$message_id, &$files)
    {
        if ($event == "USER_PASS_CHANGED") {
            $arFields["PASSWORD"] = self::singleton();
        }
    }

    private static function singleton($write = false, $newValue = false)
    {
        static $value;

        if ($write) {
            $value = $newValue;
        }

        return $value;
    }
}

/* END для отправки пароля на почту пользователю при смене пароля */

/*Событие почты при создании заказа START*/

AddEventHandler("main", "OnBeforeEventAdd", "NewOrder");

function ModifyOrderSaleMails($orderID, &$eventName, &$arFields)
{
    if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
        //СОСТАВ ЗАКАЗА РАЗБИРАЕМ SALE_ORDER НА ЗАПЧАСТИ
        $strOrderList = "";
        $dbBasketItems = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array("ORDER_ID" => $orderID),
            false,
            false,
            array("PRODUCT_ID", "ID", "NAME", "QUANTITY", "PRICE", "CURRENCY", "CML2_ARTICLE")
        );


        AddMessage2Log($arFields, "lol");
        $strCustomOrderList .= "<tr>
            <td style='padding-left: 3px;'>Артикул</td>
            <td>Наименование</td>
            <td style='text-align: center;'>Количество</td>
            <td style='text-align: right;'>Цена</td>
            <td style='text-align: right;'>Сумма</td>
            </tr>";
        while ($arProps = $dbBasketItems->Fetch()) {
            $article_find = CIBlockElement::GetProperty(
                19,
                $arProps["PRODUCT_ID"],
                array(),
                array("CODE" => "CML2_ARTICLE")
            );
            if ($article_value = $article_find->Fetch()) {
                $product_article = $article_value["VALUE"];
            } else {
                $product_article = '-';
            }

            //ПЕРЕМНОЖАЕМ КОЛИЧЕСТВО НА ЦЕНУ
            $summ = $arProps['QUANTITY'] * $arProps['PRICE'];
            //СОБИРАЕМ В СТРОКУ ТАБЛИЦЫ
            $strCustomOrderList .= "<tr>
            <td style='padding-left: 3px;'>" . $product_article . "</td>
            <td>" . $arProps['NAME'] . "</td>
            <td style='text-align: center;'>" . $arProps['QUANTITY'] . "</td>
            <td style='text-align: right;'>" . round($arProps['PRICE'], 2) . "</td>
            <td style='text-align: right;'>" . round($summ, 2) . "</td>
            </tr>";
        }
        //ОБЪЯВЛЯЕМ ПЕРЕМЕННУЮ ДЛЯ ПИСЬМА
        $arFields["ORDER_TABLE_ITEMS"] .= "<table border='1' cellpadding='1' cellspacing='1'><tbody>";
        $arFields["ORDER_TABLE_ITEMS"] .= $strCustomOrderList;
        $arFields["ORDER_TABLE_ITEMS"] .= "</tbody></table>";

        $arOrder = CSaleOrder::GetByID($orderID);

        //-- получаем телефоны и адрес
        $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
        $phone = "";
        $index = "";
        $country_name = "";
        $city_name = "";
        $address = "";
        while ($arProps = $order_props->Fetch()) {
            if ($arProps["CODE"] == "PHONE") {
                $phone = htmlspecialchars($arProps["VALUE"]);
            }
            if ($arProps["CODE"] == "LOCATION") {
                $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
                $country_name = $arLocs["COUNTRY_NAME_ORIG"];
                $city_name = $arLocs["CITY_NAME_ORIG"];
            }

            if ($arProps["CODE"] == "INDEX") {
                $index = $arProps["VALUE"];
            }

            if ($arProps["CODE"] == "ADDRESS") {
                $address = $arProps["VALUE"];
            }
        }


        $order2 = Sale\Order::load($orderID);;

        $order = CSaleOrder::GetByID($orderID);
        $user = $order['USER_ID'];
        $rsUser = CUser::GetByID($user);
        $arUser = $rsUser->Fetch();
        $user_login = $arUser["LOGIN"];
        $user_fullname = $arUser["LAST_NAME"] . ' ' . $arUser['NAME'];


        $full_address = $index . ", " . $country_name . "-" . $city_name . ", " . $address;


        $shipmentCollection = $order2->getShipmentCollection();
        foreach ($shipmentCollection as $shipment) {
            $shipment_nameDirty = $shipment->getDeliveryName(); //тут мы уже получили имя доставки
        }


        $delivery_name = "";
        if ($shipment_nameDirty) {
            $delivery_name = $shipment_nameDirty;
        }

        //-- получаем название платежной системы
        $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
        $pay_system_name = "";
        if ($arPaySystem) {
            $pay_system_name = $arPaySystem["NAME"];
        }

        //-- добавляем новые поля в массив результатов
        $arFields["ORDER_DESCRIPTION"] = $arOrder["USER_DESCRIPTION"];
        $arFields["PHONE"] = $user_login; //$arFields['LOGIN'];
        $arFields["FULLNAME"] = $user_fullname;
        $arFields["DELIVERY_NAME"] = $delivery_name;
        $arFields["PAY_SYSTEM_NAME"] = $pay_system_name;
        $arFields["FULL_ADDRESS"] = $full_address;
        $arFields['LINK_ORDER'] = "<a href='http://r1.mege-alpha.dev.4rome.ru/personal/orders/" . $arFields["ORDER_ID"] . "/'>http://r1.mege-alpha.dev.4rome.ru/personal/orders/" . $arFields["ORDER_ID"] . "/</a>";
        $arFields["PRICE_DELIVERY"] = '' . $arFields["DELIVERY_PRICE"] . ' руб';
        AddMessage2Log($arFields, "2");
    }
}


function NewOrder(&$event, &$siteId, &$arFields)
{
    if ($event != 'SALE_NEW_ORDER') {
        return true;
    }
    $arFields["CUSTOM_ORDER_LIST"] = ModifyOrderSaleMails($arFields['ORDER_ID'], $event, $arFields);
}


function raschet_volume($weight)
{
    if ($weight < 10) {
        $le = 250 / 1000;
        $he = 300 / 1000;
        $we = 170 / 1000;
        $valume = $le * $he * $we;
    } else {
        if ($weight >= 10 && $weight < 40) {
            $le = 550 / 1000;
            $he = 350 / 1000;
            $we = 350 / 1000;
            $valume = $le * $he * $we;
        } else {
            if ($weight >= 40 && $weight < 100) {
                $le = 1200 / 1000;
                $he = 800 / 1000;
                $we = 600 / 1000;
                $valume = $le * $he * $we;
            } else {
                if ($weight >= 100) {
                    $le = 1200 / 1000;
                    $he = 800 / 1000;
                    $we = 1500 / 1000;
                    $valume = $le * $he * $we;
                }
            }
        }
    }

    $arParam = array(
        "le" => $le,
        "he" => $le,
        "we" => $le,
        "volume" => $valume
    );
    return $arParam;
}

/*Событие почты при создании заказа  END*/

/*Событие для добавление обьема при создании/обновлении товара  START*/


/*Событие индексации товара START*/

AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");
function BeforeIndexHandler($arFields)
{
    if (!CModule::IncludeModule("iblock")) {
        return $arFields;
    }
    if ($arFields["MODULE_ID"] == "iblock") {
        $db_props = CIBlockElement::GetProperty(
            $arFields["PARAM2"], //BLOCK_ID индексируемого свойства
            $arFields["ITEM_ID"], //ID индексируемого свойства
            array("sort" => "asc"),  // Сортировка (можно пропустить)
            array("CODE" => "CML2_ARTICLE") //CODE свойства (в данном случае артикул)
        );

        if ($ar_props = $db_props->Fetch()) {
            //Добавим все части артикула начиная с первого символа и заказнчивая длиной не менее 3 символов
            $sku = $ar_props["VALUE"];
            $arr_sku = array();
            for ($i = 0; $i < strlen($sku); $i++) {
                $new_str = substr($sku, $i);
                if (strlen($new_str) > 2) {
                    $arr_sku[] = substr($sku, $i);
                }
            }

            $arFields["TITLE"] = " " . $arFields["TITLE"] . "  артикул: " . $ar_props["VALUE"];
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/lol.log", ($arFields["TITLE"] . "\n"), 8);
            unset($sku);
            unset($arr_sku);
        }
    }

    return $arFields;
}

/*Событие индексации товара END*/

function SendNotificationOrder()
{
    $dbRes = \Bitrix\Sale\Order::getList([
        'select' => ['ID', 'DATE_INSERT'],
        'filter' => [
            "PAYED" => "Y", //оплаченные
            "CANCELED" => "N", //не отмененные
        ],
        'order' => ['ID' => 'DESC']
    ]);
    while ($orderad = $dbRes->fetch()) {
        $order = \Bitrix\Sale\Order::load($orderad['ID']);
        $propertyCollection = $order->getPropertyCollection();
        $property = $propertyCollection->getUserEmail();
        $email = $property->getValue();
        $property = $propertyCollection->getItemByOrderPropertyCode("DATE_DELIVERY");
        $date_cur = $property->getValue();
        $date = substr(date('d.m.Y', strtotime($order->date . '1 day')), 0, 10);
        $strEmail = COption::GetOptionString('main', 'email_from');
        if ($date == $date_cur) {
            mail(
                $email,
                "Заказ №" . $orderad['ID'] . " скоро будет отгружен",
                "Информационное сообщение сайта " . $_SERVER['HTTP_HOST'] . "<br>
 ------------------------------------------<br>
 <br>
 Заказ номер " . $orderad['ID'] . " от " . $orderad['DATE_INSERT']->format("d.m.Y") . " готов к отгрузке/доставке.<br>
 <br>
 Для получения подробной информации и выбора желаемой даты отгрузки по заказу пройдите на сайт http://r1.mege-alpha.dev.4rome.ru/personal/orders/" . $orderad['ID'] . "/<br>
 <br>
#SITE_NAME#",
                "From: " . $strEmail . "\r\n" .
                "CC: " . $email . "MIME-Version: 1.0" . "\r\n" . "Content-type:text/html;charset=UTF-8" . "\r\n"
            );
        }
    }
    return true;
}


/*УБЕР ГИПЕР ПРОГА С РЕСТ АПИ*/


\Bitrix\Main\Loader::includeModule('iblock');

class NewsIBlockController extends \Bitrix\Iblock\Controller\DefaultElement
{
    protected function getDefaultPreFilters(): array
    {
        return [];
    }

    //метод определяющий какие поля разрешены для запроса через REST
    public static function getAllowedList(): array
    {
        return ['ID', 'IBLOCK_ID', "DETAIL_TEXT", "DETAIL_PICTURE", 'NAME'];
    }
}


$serviceName = 'iblock.element.RedsignB2bportalSystemDocsS1.rest.controller';
$serviceConfig = [
    'constructor' => static function () {
        return new \NewsIBlockController();
    },
];

$serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();

try {
    $serviceLocator->addInstanceLazy($serviceName, $serviceConfig);
    if ($serviceLocator->has('iblock.element.RedsignB2bportalSystemDocsS1.rest.controller')) {
        //проверка успешной регистрации сервиса
        $newsService = $serviceLocator->get('iblock.element.RedsignB2bportalSystemDocsS1.rest.controller');
        AddMessage2Log(print_r($newsService->getElementEntityAllowedList(), true));
    }
} catch (Exception $e) {
    AddMessage2Log($serviceName . " error - " . $e->getMessage());
}

/*УБЕР ГИПЕР ПРОГА С РЕСТ АПИ*/


/*Событие кратности*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementUpdateHandler");
function OnAfterIBlockElementUpdateHandler(&$arFields)
{
    \Bitrix\Main\Loader::includeModule('catalog');
    // проверяем единицы измерения, если == м2, то изменяем коэфициент с 1 на 0.001
    if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
        $r = CCatalogMeasureRatio::getList(
            $arOrder = array(),
            $arFilter = array("PRODUCT_ID" => $arFields["ID"]),
            $arGroupBy = false,
            $arNavStartParams = false,
            $arSelectFields = array()
        );

        if ($ar_r = $r->GetNext()) {
            $db_res = CCatalogMeasureRatio::update($ar_r["ID"], array("RATIO" => 2));
        }
    }

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/lol.log", print_r($ar_r, true));
}


/*Событие кратности*/



\Bitrix\Main\EventManager::getInstance()->addEventHandlerCompatible(
    'catalog',
    'OnSuccessCatalogImport1C',
    'OnSuccessCatalogImport1CHandler'
);

function OnSuccessCatalogImport1CHandler() {
    $res = CIBlockElement::GetList([], [
        "IBLOCK_ID" => 5
    ], false, false, [
        'ID', 'IBLOCK_ID', 'NAME'
    ]);
    
    
    while ($ob = $res->GetNextElement()){
        $arFields = $ob->GetFields(); // поля элемента
    
        $obPrice = new CPrice;
        $resPrice = $obPrice->GetList([], ["PRODUCT_ID" => $arFields['ID']]);
        
        $priceHidden = [ '4','6','5' ];
    
        while ($arPrice = $resPrice->Fetch()) {
            if (in_array($arPrice['CATALOG_GROUP_ID'], $priceHidden) && !empty($arPrice['PRICE'])) {
                
                $price = CCurrencyRates::ConvertCurrency($arPrice['PRICE'], $arPrice['CURRENCY'], 'RUB');
    
                $arFieldsForPrice = [
                    "PRODUCT_ID"       => $arFields['ID'],
                    "CATALOG_GROUP_ID" => 7,
                    "PRICE"            => $price,
                    "CURRENCY"         => "RUB",
                ];
                
                if ($arPrice = $resPrice->Fetch()) {
                    $obPrice->Update($arPrice["ID"], $arFieldsForPrice);
                } else {
                    $obPrice->Add($arFieldsForPrice);
                }
            }
        }
    }
}

/*Создание и Обновление элементов документов*/

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterIBlockElementAddHandler");

function OnAfterIBlockElementAddHandler(&$arFields)
{
//    file_put_contents($_SERVER['DOCUMENT_ROOT']."/lol.log",print_r($arFields,true));
    if($arFields['RESULT'] == 1 && $arFields['IBLOCK_ID'] == 3){
        $db_props = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array("CODE"=>"TYPE"));
        $check = true;
        if(!($ar_type = $db_props->Fetch()))
            $check = false;


        $db_props = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array("CODE"=>"ORDER_ID"));



        $db_props = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], array("sort" => "asc"), Array("CODE"=>"COMPANY_INN"));

        if(!($inn = $db_props->Fetch()))
            $check = false;

        file_put_contents($_SERVER['DOCUMENT_ROOT']."/lol.log",print_r($inn,true));




        if((($ar_type['VALUE'] == 303 || $ar_type['VALUE_ENUM'] == "Акт сверки" ) || ($ar_type['VALUE'] == 5 || $ar_type['VALUE_ENUM'] == "Акт выполненных работ")) && $check){


            $dbRes = \Bitrix\Sale\Order::getList([
                'select' => ['ID'],
                'filter' => [
                    "CANCELED" =>"N", //не отмененные
                    "PROPERTY.ORDER_PROPS_ID" => 10, //по свойству
                    "PROPERTY.VALUE" => $inn['VALUE'], //и по его значению
                ],
                'order' => ['ID' => 'DESC']
            ]);

            while ($orr = $dbRes->fetch()) {
                $order = \Bitrix\Sale\Order::load($orr['ID']);
                $collection = $order->getPropertyCollection();
                $propertyValue = $collection->getItemByOrderPropertyCode("ISAСT");
                $propertyValue->setField('VALUE', 'N');
                $order->save();
            }

        }

    }
}

?>