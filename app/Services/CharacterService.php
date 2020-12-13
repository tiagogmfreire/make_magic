<?php 

namespace App\Services;

use App\Models\Character;
use Illuminate\Validation\ValidationException;

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
    public function save(string $house_id, string $name, string $school, string $patronus, int $id = null)
    {
        $characterModel = null;

        if (!empty($id)) {
            $characterModel = Character::find($id);

            if(empty($characterModel)) {
                throw new \Exception("Invalid character ID");
            }
        }
        
        if (empty($characterModel)) {
            $characterModel = new Character();
        } 

        $characterModel->house_id = 1;
        $characterModel->name = $name;
        $characterModel->school = $school;
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