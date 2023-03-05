<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getCountries($id = null)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => $id ? getCountry($id) : getAllCountries()
        ];

        return response()->json($response, 200);
    }


    public function getStates($id)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => getStates($id)
        ];

        return response()->json($response, 200);
    }

    public function getcities($id)
    {
        $response = [
            'status' => 200,
            'message' => "",
            'data' => getCities($id)
        ];

        return response()->json($response, 200);
    }
}
