<?php 

namespace App\Services;

use App\Models\Character;

/**
 * Class that contains all buiness logic 
 * for the domain object "Character"
 */
class CharacterService
{
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
     * Method for creating new characters
     *
     * @param array $data Array containing all data for the new character
     * @return Character The newly created character object
     */
    public function create($data)
    {
        $characterModel = new Character();

        $characterModel->house_id = 1;
        $characterModel->name = $data['name'];
        $characterModel->school = $data['school'];
        $characterModel->patronus = $data['patronus'];

        $characterModel->save();

        return $characterModel;
    }
}