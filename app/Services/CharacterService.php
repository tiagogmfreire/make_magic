<?php 

namespace App\Services;

use App\Models\Character;
use Illuminate\Validation\ValidationException;
use App\Services\HouseService;

/**
 * Class that contains all buiness logic 
 * for the domain object "Character"
 */
class CharacterService
{

    private HouseService $houseService;

    public function __construct(HouseService $houseService)
    {
        $this->houseService = $houseService;
    }

    /**
     * Method to list all the characters
     *
     * @return array Returns an array with all characters
     */
    public function list()
    {
        $chars = Character::all();

        return $chars;
    }

    /**
     * Method to retrieve data from a single
     * character by its id
     *
     * @param int $id The id of the character
     * 
     * @return Character The found character
     */
    public function get($id)
    {
        $char = Character::find($id);

        return $char;
    }

    /**
     * Method do create/update characters. If the id of the character 
     * is informed will update the existing character, if not, a new one
     * will be created.
     *
     * @param string $house_id
     * @param string $name
     * @param string $school
     * @param string $patronus
     * 
     * @param integer $id Character id in case of updating (default null)
     * 
     * @return Character
     */
    public function save(string $house_id, string $name, string $patronus, int $id = null)
    {
        $characterModel = null;

        // calling the house service class to search by the api_id
        $houseModel = $this->houseService->search($house_id);

        // if the house has not been found throws a exception
        if (empty($houseModel)) {
            throw new \Exception("Invalid house ID", 1);
        }

        // if the id is not null tries to updating an existing character
        if (!empty($id)) {
            $characterModel = Character::find($id);
        }

        // dealing with invalid character ids (not found and zero)
        if(!empty($id) && empty($characterModel) || $id === 0) {
            throw new \Exception("Invalid character ID");
        }
        
        // If the var $characterModel is still null then creates a new character
        if (empty($characterModel)) {
            $characterModel = new Character();
        } 

        $characterModel->house_id = $houseModel->id;
        $characterModel->name = $name;
        $characterModel->patronus = $patronus;

        $characterModel->save();

        return $characterModel;
    }

    public function delete($id)
    {
        $characterModel = Character::find($id);

        $characterModel->delete();
    }
}