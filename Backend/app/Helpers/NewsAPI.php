<?php

namespace App\Helpers;

use Auth;
use Exception;

class NewsAPI
{
    public static function fetchNews()
    {
        // the URL endpoint for NewsAPI
        $url = 'https://newsapi.org/v2/top-headlines?country=us';

        // the API key for NewsAPI
        $api_key = '1b8f77268c6b4bf0b0cb992cb20de55e';

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
