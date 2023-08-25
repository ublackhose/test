<?php



function getSoapDiliveryMajorLTL($ru_name_city = null, $weight = 1.0, $cost = 1.0,$volume = 1.0)
{
    if ($ru_name_city) {
        $client = new SoapClient('https://ltl-ws.major-express.ru/ltl.asmx?WSDL');
        $citys = json_decode(json_encode($client->dict_Cities()), true);
        $city_to = null;
        foreach ($citys['dict_CitiesResult']['enc_value']['City'] as $item) {
            if ($item['Name'] == $ru_name_city) {
                $item['Name'] = trim(preg_replace('/\s*\(.*?\)/', '', $item['Name']));
                $city_to = $item;
            }
        }


        if ($city_to) {
            $calc = json_decode(
                json_encode(
                    $client->CalculatorByWB(
                        [
                            "ShipperCityID" => 129,
                            "ConsigneeCityID" => $city_to['Code'],
                            "Weight" => $weight,
                            "Volume"=> $volume,
                            "Cost" => $cost
                        ]
                    )
                ),
                true
            );


            if ($calc['CalculatorByWBResult']['enc_value']['LTL_Calculator']) {
                $calc = $calc['CalculatorByWBResult']['enc_value']['LTL_Calculator'];
                return $calc;
            }else{
                return null;
            }
        } else {
            return null;
        }
    }
    return null;
}
?>