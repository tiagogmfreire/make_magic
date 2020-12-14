<?php 

namespace App\Services;

use App\Models\House;
use \GuzzleHttp\Client;
use function GuzzleHttp\Utils;

/**
 * Class that contains all business logic 
 * for the domain object "House"
 */
class HouseService
{

    /**
     * Searchs for a house in the database by its external api
     * ID.
     *
     * @param string $api_id ID of the house in the external API
     * 
     * @return houseModel
     */
    public function search($api_id)
    {
        $houseModel = House::where('api_id', $api_id)->first();

        return $houseModel;
    }

    /**
     * Method to list all houses
     *
     * @return array Returns a array with all houses
     */
    public function list()
    {
        $houses = House::all();

        return $houses;
    }

    /**
     * Method to import houses from an external
     * API and save them in the database
     *
     * @return void
     */
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

    /**
     * Method that saves houses from an array
     * into the database
     *
     * @param array $array Array with house data
     * @return void
     */
    public function saveArray($array)
    {
        try {

            foreach( $array['houses'] as $house) {

                $houseModel = new House();
    
                $houseModel = House::where('api_id', $house['id'])->first();
    
                if (empty($houseModel)) {
                    $houseModel = new House();
                }
    
                $houseModel->api_id= $house['id'];
                $houseModel->name= $house['name'] ?? '';
                $houseModel->head= $house['headOfHouse'] ?? NULL;
                $houseModel->school= $house['school'] ?? NULL;
                $houseModel->mascot= $house['mascot'] ?? NULL;
                $houseModel->ghost= $house['houseGhost'] ?? NULL;
                $houseModel->founder= $house['founder'] ?? NULL;
                
                $houseModel->save();
            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
}