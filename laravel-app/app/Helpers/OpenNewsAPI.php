<?php

namespace App\Helpers;

use Exception;

class OpenNewsAPI
{
    public static function fetchNews($filters = [])
    {
        // append page size
        $filters['pageSize'] = 10;

        // set query params
        if (array_key_exists("q", $filters)) {
            $filters["query"] = $filters["q"];
            unset($filters["q"]);
        }

        if (array_key_exists("from", $filters)) {
            $filters["startDate"] = $filters["from"];
            unset($filters["from"]);
        }

        // make query string
        $query = http_build_query($filters);

        // the URL endpoint for OpenNewsAPI
        $url = 'https://bloomberg-market-and-financial-news.p.rapidapi.com/market/auto-complete?' . $query;

        // the API key for OpenNewsAPI
        $api_host = env('OPEN_NEWS_API_HOST');
        $api_key = env('OPEN_NEWS_API_KEY');

        // Create a new cURL resource
        $curl = curl_init();

        // Set the URL and other options
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: " . $api_host,
                "X-RapidAPI-Key: " . $api_key
            ],
        ]);

        // Send the request and get the response
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // Check for errors
        if ($err) {
            throw new Exception($err);
        }

        return json_decode($response);
    }
}
