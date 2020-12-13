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

            $chars = $characterService->list();

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
            $school = $request->input("school");
            $patronus = $request->input("patronus");

            $character = $characterService->create(
                $house,
                $name,
                $school,
                $patronus
            );

            return response()->json($character->id);
                
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function update($id, Request $request, CharacterService $characterService)
    {

    }

    public function destroy($id, Request $request, CharacterService $characterService)
    {

    }
}
