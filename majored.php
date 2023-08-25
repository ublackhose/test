<?php



function getSoapDiliveryMajorED($ru_name_city = null, $weight = 1.0, $cost = 1.0)
{
    if ($ru_name_city) {
        $client = new SoapClient('https://ltl-ws.major-express.ru/ed.asmx?WSDL');


        $citys = json_decode(json_encode($client->dict_Cities()), true);



        $city_to = null;
        foreach ($citys['dict_CitiesResult']['enc_value']['EDCity'] as $item) {
            if ($item['Name'] == $ru_name_city) {
                $item['Name'] = trim(preg_replace('/\s*\(.*?\)/', '', $item['Name']));
                $city_to = $item;
            }
        }



        if ($city_to) {
            $calc = json_decode(
                json_encode(
                    $client->Calculator(
                        [
                            "ShipperCityCode" => 129,
                            "ConsigneeCityCode" => $city_to['Code'],
                            "Weight" => $weight,
                            "Cost" => $cost
                        ]
                    )
                ),
                true
            );

            if ($calc['CalculatorResult']['enc_value']['CityName']) {
                $calc = $calc['CalculatorResult']['enc_value'];
                return $calc;
            }else{
                return null;
            }
        } else {
            return null;
        }
    }else{
        return null;
    }
}



