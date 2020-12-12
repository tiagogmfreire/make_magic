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

            var_dump($houses);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}