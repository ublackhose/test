<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once __DIR__ . '/bitrix/php_interface/crm_import/crest.php';

$data = [
    'TITLE' => 'ТЕСТОВЫЙ ЛИД',
    'SOURCE_ID' => 3,
    'NAME' => 'Тестовое имя',
    'PHONE' => array(
        'n0' => array(
            'VALUE' =>  '+7 999 999 99 99',
            'VALUE_TYPE' => 'MOBILE',
        ),
    ),
    'COMMENTS' => 'test',
    'ASSIGNED_BY_ID' => 6391,

];

// $result = CRest::call(
//     'crm.lead.add',
//     [
//         'fields' => $data
//     ]);

// echo '<pre data-test style="color: #c3c3c3; background: #282923; padding: 15px 5px;">';
// print_r($result);
// echo '</pre>';


// $string = "https://mege-alpha.dev.4rome.ru/confirmUser/?userId=";


// echo '<pre data-test style="color: #c3c3c3; background: #282923; padding: 15px 5px;">';
// print_r($string);
// echo '</pre>';





//*---------------------------------------------------------------------

// $bitrixFields = [
//     'TITLE' => 'ТЕСТОВЫЙ ЛИД',
//     'SOURCE_ID' => 3,
//     'NAME' => 'Тестовое имя',
//     'PHONE' => array(
//         'n0' => array(
//             'VALUE' =>  '+7 999 999 99 99',
//             'VALUE_TYPE' => 'MOBILE',
//         ),
//     ),
//     'COMMENTS' => 'test',
//     'ASSIGNED_BY_ID' => 6391,

// ];

// $bitrixQuery = 'http://192.168.136.10/rest/6391/jatd2cfmora8q373/crm.lead.add.json';

// $headers_json = [
//     'Accept: application/json',
//     'Content-Type: application/json',
// ];
    
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($bitrixFields));
// curl_setopt($curl, CURLOPT_URL, $bitrixQuery);
// curl_setopt($curl, CURLOPT_HEADER, false);
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers_json);

// $outs = curl_exec($curl);

// echo '<pre data-test style="color: #c3c3c3; background: #282923; padding: 15px 5px;">';
// print_r(curl_error($curl));
// echo '</pre>';

// curl_close($curl);
// $result = json_decode($outs, true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>