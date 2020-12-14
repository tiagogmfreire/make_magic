<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Services\CharacterService;
use App\Services\HouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Controller to manage all requests related to
 * Characters
 */
class CharacterController extends Controller
{
    /**
     * Action to show all characters
     *
     * @param Request $request
     * @param CharacterService $characterService
     * 
     * @return response A json response
     */
    public function index(Request $request, CharacterService $characterService)
    {
        try {

            $house = $request->input('house');

            $chars = $characterService->list($house);

            return response()->json($chars);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Action to get a single character by its ID
     *
     * @param int $id
     * @param Request $request
     * @param CharacterService $characterService
     * 
     * @return response A json response
     */
    public function show($id, Request $request, CharacterService $characterService)
    {
        try {

            $char = $characterService->get($id);

            return response()->json($char);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Uses Lumen validation facade to validate input
     * with character information.
     *
     * @param Request $request
     * @param HouseService $houseService
     * 
     * @return void
     */
    protected function validateChar(Request $request, HouseService $houseService)
    {
        $rules = [
            "house" => 'required|string',
            "name" => 'required|string',
            "patronus" => 'nullable|string',
            "hair_color" => 'nullable|string',
            "eye_color" => 'nullable|string',
            "gender" => 'nullable|string',
            "dead" => 'nullable|boolean',
            "birthday" => 'nullable|date_format:Y-m-d',
            "death_date" => 'nullable|date_format:Y-m-d',
        ]; 

        $validator = Validator::make(
            $request->post(), //getting all post data as array for validation
            //validation rules
            $rules,
            // custom messages
            [
                'date_format' => 'Dates must follow ISO 8601 standard: YYYY-MM-DD',
            ]
        );

        // checking if the request passed validation
        if ($validator->fails()) {

            // aborting with the propper message and "bad request" status code
            abort(400, $validator->errors());
        }

        // validating the house id
        if (!$houseService->validate($request->input("house"))) {
            abort(200, "Invalid house id");
        }

        return true;
    }

    /**
     * Method to create new characteres
     *
     * @param Request $request
     * @param CharacterService $characterService
     * @param HouseService $houseService
     * 
     * @return response Json response
     */
    public function store(Request $request, CharacterService $characterService, HouseService $houseService)
    {
        try {

            //validate input (and abort if it fails)
            $this->validateChar($request, $houseService);

            $birthday = \DateTime::createFromFormat('Y-m-d',$request->input("birthday"));
            $death_date = \DateTime::createFromFormat('Y-m-d', $request->input("death_date"));

            // if datetime returns false then it's not a valid date format
            $birthday = !empty($birthday)? $birthday : null;
            $death_date = !empty($death_date)? $death_date : null;

            $character = $characterService->save(
                $request->input("house"),
                $request->input("name"),
                $request->input("patronus"),
                $request->input("hair_color"),
                $request->input("eye_color"),
                $request->input("gender"),
                $request->input("dead"),
                $birthday,
                $death_date
            );

            return response()->json($character);
                
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Updates an existing character by its id
     *
     * @param int $id
     * @param Request $request
     * @param CharacterService $characterService
     * 
     * @return response
     */
    public function update($id, Request $request, CharacterService $characterService, HouseService $houseService)
    {
        try {

            //validate input (and abort if it fails)
            $this->validateChar($request, $houseService);

            //validate character id
            if (!$characterService->validate((int)$id)) {
                abort(400, "Invalid character id");
            }

            $birthday = \DateTime::createFromFormat('Y-m-d',$request->input("birthday"));
            $death_date = \DateTime::createFromFormat('Y-m-d', $request->input("death_date"));

            // if datetime returns false then it's not a valid date format
            $birthday = !empty($birthday)? $birthday : null;
            $death_date = !empty($death_date)? $death_date : null;

            $character = $characterService->save(
                $request->input("house"),
                $request->input("name"),
                $request->input("patronus"),
                $request->input("hair_color"),
                $request->input("eye_color"),
                $request->input("gender"),
                $request->input("dead"),
                $birthday,
                $death_date,
                $id
            );

            return response()->json($character);
                
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Deletes a character by its id
     *
     * @param int $id
     * @param Request $request
     * @param CharacterService $characterService
     * 
     * @return response
     */
    public function destroy($id, Request $request, CharacterService $characterService)
    {
        try {

            $characterService->delete($id);

            return response()->json("success");
                
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
