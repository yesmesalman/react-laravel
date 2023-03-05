<?php

namespace App\Helpers;

use Exception;

class PerigonAPI
{
    public static function fetchNews($filters = [])
    {
        // append page size
        $filters['pageSize'] = 10;

        // make query string
        $query = http_build_query($filters);

        // the URL endpoint for OpenNewsAPI
        $url = 'https://api.goperigon.com/v1/all?' . $query;

        // the API key for OpenNewsAPI
        $api_key = env('PERIGON_API_KEY');
        $url = $url . "&apiKey=" . $api_key;

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
