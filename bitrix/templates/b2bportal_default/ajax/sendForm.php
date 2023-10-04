<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<?
// file_put_contents(__DIR__.'/$_POST1.log', print_r($_POST, true));
// $res = CEvent::Send("CHANGE_PROFILE_DATA", "s1", $_POST);


// $post = Array(
//     'sessid' => '2ff3bdacd765e3b8f94ecc325ab13e91',
//     'ID' => 38,
//     'ORDER_PROP_52' => 0,
//     'ORDER_PROP_31' => '33993.57sdfsdf',
//     'ORDER_PROP_22' => 'Почти начальникsdfsdf 1',
//     'ORDER_PROP_20' => 'Продажа',
//     'ORDER_PROP_23' => 'no',
//     'ORDER_PROP_25' => 'test',
//     'ORDER_PROP_26' => 'sdfsdfsdf',
//     'ORDER_PROP_24' => 'test',
//     'ORDER_PROP_13' => 'asd@asd.ru',
//     'ORDER_PROP_14' => '79999999999',
//     'ORDER_PROP_15' => '',
//     'ORDER_PROP_16' => '6161616',
//     'ORDER_PROP_17' => 'Москва',
// );

$post = $_POST;

if (is_array($post)) {

    $query = new \Bitrix\Main\Entity\Query(Bitrix\Sale\Internals\UserPropsTable::getEntity());
    $profile = $query
        ->setSelect(array("ID", "NAME", "PERSON_TYPE_ID"))
        ->setFilter(array("ID" => $post['ID']))
        ->exec()
        ->fetch();

    $personType = [
        1 => 'Физическое лицо',
        2 => 'Юридическое лицо',
    ];

    $data = [
        'TITLE' => 'Заявка на изменение реквизитов или платежных данных от профиля - ' . $profile['NAME'],
        'SOURCE_ID' => 3,
        // 'NAME' => 'Заявка на изменение реквизитов или платежных данных от компании',
        'COMMENTS' => 'тестирование',
        'ASSIGNED_BY_ID' => 6391,
        'UF_CRM_1688104595621' => $personType[$profile['PERSON_TYPE_ID']], // физ или юр лицо
        'UF_CRM_1688104547987' => $profile['NAME'], // название профиля
    
    ];
    
    foreach ($post as $key => $value) {
        switch ($key) {
            case 'ORDER_PROP_22':
                $data['UF_CRM_1689061823844'] = $value;
                break;
            case 'ORDER_PROP_20':
                $data['UF_CRM_1689061781159'] = $value;
                break;
            case 'ORDER_PROP_23':
                $data['UF_CRM_1689062834871'] = $value;
                break;
            case 'ORDER_PROP_25':
                $data['UF_CRM_1689063827973'] = $value;
                break;
            case 'ORDER_PROP_26':
                $data['UF_CRM_1689063856950'] = $value;
                break;
            case 'ORDER_PROP_24':
                $data['UF_CRM_1689063839369'] = $value;
                break;
            case 'ORDER_PROP_10':
                $data['UF_CRM_1689063809839'] = $value;
                break;
            case 'ORDER_PROP_11':
                $data['UF_CRM_1689063818577'] = $value;
                break;
            case 'ORDER_PROP_14':
                $data['UF_CRM_1689062929363'] = $value;
                break;
            case 'ORDER_PROP_15':
                $data[] = $value;
                break;
            case 'ORDER_PROP_19':
                $data['UF_CRM_1689062953837'] = $value;
                break;
            case 'ORDER_PROP_1':
                $data['UF_CRM_1688104643675'] = $value;
                break;
            case 'ORDER_PROP_2':
                $data['UF_CRM_1688104661687'] = $value;
                break;
            case 'ORDER_PROP_3':
                $data['UF_CRM_1688104682447'] = $value;
                break;
            case 'ORDER_PROP_7':
                $data['UF_CRM_1688104746393'] = $value;
                break;
            case 'ORDER_PROP_8':
                $data['UF_CRM_1688104793493'] = $value;
                break;
        }
    }
}


$result = CRest::call(
    'crm.lead.add',
    [
        'fields' => $data
    ]
);

if (!empty($result['result'])) {
    echo 'ok';
}