<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Enums\UserTypes;
use App\Helpers\NewsAPI;
use App\Models\User;
use Hash;
use Exception;

class NewsController extends Controller
{
    public function index()
    {
        try {

            $newsAPI = NewsAPI::fetchNews();

            $response = [
                'status' => 200,
                'message' => 'sdfasdfasdfas',
                'data' => [
                    "news_api" => $newsAPI
                ]
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => "Something went wrong!",
            ], 422);
        }
    }
}
