<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Services\CharacterService;
use Illuminate\Http\Request;

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
     * Method to create new characteres
     *
     * @param Request $request
     * @param CharacterService $characterService
     * 
     * @return response Json response
     */
    public function store(Request $request, CharacterService $characterService)
    {
        try {

            $house = $request->input("house");
            $name = $request->input("name");
            $patronus = $request->input("patronus");
            $hair_color = $request->input("hair_color");
            $eye_color = $request->input("eye_color");
            $gender = $request->input("gender");
            $dead = $request->input("dead");
            $birthday = $request->input("birthday");
            $death_date = $request->input("death_date");

            $character = $characterService->save(
                $house,
                $name,
                $patronus,
                $hair_color,
                $eye_color,
                $gender,
                $dead,
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
    public function update($id, Request $request, CharacterService $characterService)
    {
        try {

            $house = $request->input("house");
            $name = $request->input("name");
            $patronus = $request->input("patronus");
            $hair_color = $request->input("hair_color");
            $eye_color = $request->input("eye_color");
            $gender = $request->input("gender");
            $dead = $request->input("dead");
            $birthday = $request->input("birthday");
            $death_date = $request->input("death_date");

            $character = $characterService->save(
                $house,
                $name,
                $patronus,
                $hair_color,
                $eye_color,
                $gender,
                $dead,
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
