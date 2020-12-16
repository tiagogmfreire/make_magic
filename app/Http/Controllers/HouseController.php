<?php

namespace App\Http\Controllers;

use App\Services\HouseService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *   schema="HouseSchema",
 *   title="House Model",
 *   description="User model",
 *   @OA\Property(
 *     property="id", description="internal ID of the house",
 *     @OA\Schema(type="number", example=1)
 *  ),
 *   @OA\Property(
 *     property="api_id", description="external ID of the house",
 *     @OA\Schema(type="string", example="1760529f-6d51-4cb1-bcb1-25087fce5bde")
 *  ),
 *  @OA\Property(
 *     property="name", description="name of the house",
 *     @OA\Schema(type="string", example="Gryffindor")
 *  ),
 *  @OA\Property(
 *     property="head", description="head of the house",
 *     @OA\Schema(type="string", example="Minerva McGonagall")
 *  ),
 *  @OA\Property(
 *     property="school", description="name of the school",
 *     @OA\Schema(type="string", example="Hogwarts School of Witchcraft and Wizardry")
 *  ),
 *  @OA\Property(
 *     property="mascot", description="mascot of the house",
 *     @OA\Schema(type="string", example="lion")
 *  ),
 *  @OA\Property(
 *     property="ghost", description="ghost of the house",
 *     @OA\Schema(type="string", example="Nearly Headless Nick")
 *  ),
 *  @OA\Property(
 *     property="founder", description="founder of the house",
 *     @OA\Schema(type="string", example="Goderic Gryffindor")
 *  )
 * )
 * 
 */
class HouseController extends Controller
{
    /**
     * Lists all houses
     *
     * @param Request $request
     * @param HouseService $houseService
     * 
     * @return response
     * 
     * @OA\Get(
     *   path="/houses",
     *   summary="Return the list of houses",
     *   tags={"House"},
     *    @OA\Response(
     *      response=200,
     *      description="List of users",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          description="List of users",
     *          @OA\Schema(
     *            type="array",
     *            @OA\Items(ref="#/components/schemas/HouseSchema")
     *          )
     *        )
     *      )
     *    )
     * )
     */
    public function index(Request $request, HouseService $houseService) 
    {
        try {

            $houses = $houseService->list();

            return response()->json($houses);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
