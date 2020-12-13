<?php 

namespace App\Services;

use App\Models\House;
use \GuzzleHttp\Client;
use function GuzzleHttp\json_decode;

class HouseService
{

    public function import_from_api()
    {
        try {

            $url = env('API_URL');

            $endpoint = $url . '/houses';

            $client = new Client();

            $response = $client->request('GET', $endpoint, [
                'headers' => [
                    'apikey' => env('API_KEY')
                ]
            ]);

            $houses = json_decode($response->getBody(), true);

            $this->saveArray($houses);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function saveArray($array)
    {
        foreach( $array['houses'] as $house) {

            $houseModel = new House();

            $houseModel = House::where('api_id', $house['id'])->first();

            if (empty($houseModel)) {
                $houseModel = new House();
            }

            $houseModel->api_id= $house['id'];
            $houseModel->name= $house['name'];
            $houseModel->head= $house['headOfHouse'];
            $houseModel->school= isset($house['school'])? $house['school'] : "";
            $houseModel->mascot= $house['mascot'];
            $houseModel->ghost= $house['houseGhost'];
            $houseModel->founder= $house['founder'];
            
            $houseModel->save();
        }

        try {



            

        } catch (\Exception $e) {
            throw $e;
        }
    }
}