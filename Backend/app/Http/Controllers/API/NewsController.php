<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\NewsAPI;
use App\Helpers\OpenNewsAPI;
use App\Helpers\PerigonAPI;
use Exception;

class NewsController extends Controller
{
    private function shuffleItems($arr)
    {
        $count = count($arr);
        for ($i = $count - 1; $i > 0; $i--) {
            $j = rand(0, $i);
            $tmp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $tmp;
        }
        return $arr;
    }

    public function index(Request $request)
    {
        try {
            $data = [];
            $filters = $request->all();

            $newsAPI = NewsAPI::fetchNews($filters);
            $openNewsAPI = OpenNewsAPI::fetchNews($filters);
            $perigonAPI = PerigonAPI::fetchNews($filters);

            if (isset($newsAPI->articles)) {
                foreach ($newsAPI->articles as $item) {
                    array_push($data, [
                        "id" => $item->publishedAt,
                        "source" => "news_api",
                        "title" => $item->title,
                        "description" => $item->description,
                        "url" => $item->url,
                        "datetime" => date("h:m A d-m-Y", strtotime($item->publishedAt)),
                    ]);
                }
            }

            if (isset($openNewsAPI->news)) {
                foreach ($openNewsAPI->news as $item) {
                    array_push($data, [
                        "id" => $item->id,
                        "source" => "open_news_api",
                        "title" => $item->title,
                        "description" => null,
                        "url" => $item->longURL,
                        "datetime" => date("h:m A d-m-Y", $item->date),
                    ]);
                }
            }

            foreach ($perigonAPI->articles as $item) {
                array_push($data, [
                    "id" => $item->articleId,
                    "source" => "perigon_api",
                    "title" => $item->title,
                    "description" => $item->description,
                    "url" => $item->url,
                    "datetime" => date("h:m A d-m-Y", strtotime($item->pubDate)),
                ]);
            }

            $data = $this->shuffleItems($data);
            $response = [
                'status' => 200,
                'message' => 'sdfasdfasdfas',
                'data' => $data
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 422,
                'message' => "Something went wrong! " . $e->getMessage(),
            ], 422);
        }
    }
}
