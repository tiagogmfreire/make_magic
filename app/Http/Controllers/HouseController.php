<?php

namespace App\Http\Controllers;

use App\Services\HouseService;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Lists all houses
     *
     * @param Request $request
     * @param HouseService $houseService
     * 
     * @return response
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
