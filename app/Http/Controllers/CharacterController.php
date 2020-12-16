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
 * 
 * @OA\Schema(
 *   schema="CharacterSchema",
 *   title="Character Schema",
 *   description="Character Schema",
 *   @OA\Property(
 *     property="id", description="ID of the character",
 *     @OA\Schema(type="number", example=1)
 *  ),
 *   @OA\Property(
 *     property="house_id", description="internal id of the character's house",
 *     @OA\Schema(type="number", example="1")
 *  ),
 *  @OA\Property(
 *     property="name", description="name of the character",
 *     @OA\Schema(type="string", example="Harry Potter")
 *  ),
 *  @OA\Property(
 *     property="patronus", description="patronus of the character",
 *     @OA\Schema(type="string", example="Stag")
 *  ),
 *  @OA\Property(
 *     property="hair_color", description="hair color of the character",
 *     @OA\Schema(type="string", example="Black")
 *  ),
 *  @OA\Property(
 *     property="eye_color", description="eye color of the character",
 *     @OA\Schema(type="string", example="Green")
 *  ),
 *  @OA\Property(
 *     property="gender", description="gender of the character",
 *     @OA\Schema(type="string", example="Male")
 *  ),
 *  @OA\Property(
 *     property="dead", description="flag to tell if the character is dead",
 *     @OA\Schema(type="boolean", example="False")
 *  ),
 *  @OA\Property(
 *     property="birthday", description="birthday of the character is dead in ISO 8601 standard: YYYY-MM-DD",
 *     @OA\Schema(type="date", example="False")
 *  ),
 *  @OA\Property(
 *     property="death_date", description="death date for dead characters in ISO 8601 standard: YYYY-MM-DD",
 *     @OA\Schema(type="date", example="False")
 *  )
 * )
 */
// We can define the request parameter inside the Requests or here
/**
 * @OA\Parameter(
 *   parameter="get_chars_request_parameter_limit",
 *   name="limit",
 *   description="Limit the number of results",
 *   in="query",
 *   @OA\Schema(
 *     type="number", default=10
 *   )
 * ),
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
     * 
     * @OA\Get(
     *   path="/characters",
     *   summary="Return the list of characters",
     *   tags={"Character"},
     *   @OA\Parameter(ref="#/components/parameters/get_chars_request_parameter_limit"),
     *    @OA\Response(
     *      response=200,
     *      description="List of Characters",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="List of Characters",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/CharacterSchema")
     *          )
     *        )
     *      )
     *    )
     * )
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
     * 
     * @OA\Get(
     *   path="/characters/{id}",
     *   summary="Returns details from a single character by id",
     *   tags={"Character"},
     *   @OA\Parameter(ref="#/components/parameters/get_chars_request_parameter_limit"),
     *    @OA\Response(
     *      response=200,
     *      description="Characters details",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="Characters details",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/CharacterSchema")
     *          )
     *        )
     *      )
     *    )
     * )
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
     * 
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
     * 
     * @OA\Post(
     *   path="/characters",
     *   summary="Creates a new character",
     *   tags={"Character"},
     *   @OA\Parameter(ref="#/components/parameters/get_chars_request_parameter_limit"),
     *    @OA\Response(
     *      response=200,
     *      description="Creates a new character",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="Creates a new character",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/CharacterSchema")
     *          )
     *        )
     *      )
     *    )
     * )
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

            // returning the response with the created object and location header
            return response()
                    ->json(
                        $character,
                        201
                    )
                    ->header('Location', '/characters/'.$character->id);
                
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
     * 
     * @OA\Put(
     *   path="/characters/{id}",
     *   summary="Updates a character by id",
     *   tags={"Character"},
     *   @OA\Parameter(ref="#/components/parameters/get_chars_request_parameter_limit"),
     *    @OA\Response(
     *      response=200,
     *      description="Updates a character by id",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="Updates a character by id",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/CharacterSchema")
     *          )
     *        )
     *      )
     *    )
     * )
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

            // returning the response with the created object and location header
            return response()
                    ->json(
                        $character,
                        201
                    )
                    ->header('Location', '/characters/'.$character->id);
                
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
     * 
     * @OA\Delete(
     *   path="/characters/{id}",
     *   summary="Removes a character by id",
     *   tags={"Character"},
     *   @OA\Parameter(ref="#/components/parameters/get_chars_request_parameter_limit"),
     *    @OA\Response(
     *      response=200,
     *      description="Removes a character by id",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="Removes a character by id",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/CharacterSchema")
     *          )
     *        )
     *      )
     *    )
     * )
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
