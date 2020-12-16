<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Validation\ValidationException;
use App\Services\HouseService;

/**
 * Class that contains all business logic 
 * for the domain object "Character"
 */
class CharacterService
{
    private HouseService $houseService;

    /**
     * The constructor requires a HouseService object
     *
     * @param HouseService $houseService
     */
    public function __construct(HouseService $houseService)
    {
        $this->houseService = $houseService;
    }

    /**
     * Checks if the character already exists 
     * in the database
     *
     * @param integer $id The character's id
     * 
     * @return bool True for valid and false otherwise
     */
    public function validate($id)
    {
        $valid = false;

        $char = $this->get((int)$id);

        if (!empty($char)) {

            $valid = true;
        }

        return $valid;
    }

    /**
     * Method to list all the characters
     * 
     * @param string|null $house
     *
     * @return array Returns an array with all characters
     */
    public function list(?string $house = null)
    {
        if (!empty($house)) {

            $houseModel = $this->houseService->search($house);

            $chars = Character::where('house_id', $houseModel->id)
                                ->with('house')
                                ->get();

        } else {

            $chars = Character::with('house')->get();
        }

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
        $char = Character::where('id', (int)$id)
                            ->with('house')
                            ->first();

        return $char;
    }

    /**
     * Method do create/update characters. If the id of the character 
     * is informed will update the existing character, if not, a new one
     * will be created.
     * 
     * @param string $house_id The house id from the external API 
     * @param string $name The name of the character
     * @param string|null $patronus The name of the patronus
     * @param string|null $hair_color The hair color name
     * @param string|null $eye_color The eye color name
     * @param string|null $gender the gender as full text
     * @param boolean|null $dead Flag to indicate if the character is dead
     * @param string|null $birthday birthday of the character
     * @param string|null $death_date the date of death for dead characters
     * 
     * @param integer|null $id the id of an existing character to be updated
     * 
     * @return void
     */
    public function save(
        string $house_id,
        string $name,
        ?string $patronus,
        ?string $hair_color,
        ?string $eye_color,
        ?string $gender,
        ?bool $dead,
        ?\DateTime $birthday,
        ?\DateTime $death_date,
        ?int $id = null
    ) 
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
        if (!empty($id) && empty($characterModel) || $id === 0) {
            throw new \Exception("Invalid character ID");
        }

        // If the var $characterModel is still null then creates a new character
        if (empty($characterModel)) {
            $characterModel = new Character();
        }

        $characterModel->house_id = $houseModel->id;
        $characterModel->name = $name;
        $characterModel->patronus = $patronus;
        $characterModel->hair_color = $hair_color;
        $characterModel->eye_color = $eye_color;
        $characterModel->gender = $gender;
        $characterModel->dead = $dead;
        $characterModel->birthday = $birthday;
        $characterModel->death_date = $death_date;

        $characterModel->save();

        return $characterModel;
    }

    /**
     * Method to deleter character using
     * softdelete.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        $characterModel = Character::find($id);

        if (empty($characterModel)) {
            return false;
        }

        return $characterModel->delete();
    }

    /**
     * Method to restore deleted characters
     *
     * @param integer $id
     * 
     * @return void
     */
    public function restore(int $id)
    {
        $characterModel = Character::withTrashed()->find($id);

        if (empty($characterModel)) {
            return false;
        }

        $characterModel->restore();

        return $characterModel;
    }
}
