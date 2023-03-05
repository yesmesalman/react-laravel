<?php

namespace App\Helpers;

use Auth;
use Exception;

class NewsAPI
{
    public static function fetchNews($filters = [])
    {
        // append page size
        $filters['pageSize'] = 10;

        // make query string
        $query = http_build_query($filters);

        // the URL endpoint for NewsAPI
        $url = 'https://newsapi.org/v2/top-headlines?country=us&' . $query;

        // the API key for NewsAPI
        $api_key = env('NEWS_API_KEY');

        // Create a new cURL resource
        $curl = curl_init();

        // Set the URL and other options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $api_key,
                'User-Agent: my-news-app/1.0'
            ),
        ));

        // Send the request and get the response
        $response = curl_exec($curl);

        // Check for errors
        if (curl_errno($curl)) {
            throw new Exception(curl_error($curl));
        }

        // Close the cURL resource
        curl_close($curl);

        return json_decode($response);
    }
}
