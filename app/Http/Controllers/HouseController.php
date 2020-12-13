<?php

namespace App\Http\Controllers;

use App\Services\HouseService;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(Request $request, HouseService $houseService) 
    {
        try {

            $houses = $houseService->list();

            return response()->json($houses);

        } catch (\Exception $e) {

        }
    }
}
