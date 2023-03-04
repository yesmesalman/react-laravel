<?php

use Khsing\World\Models\Country;
use Khsing\World\Models\Division;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Wallet;
use App\Models\Setting;


function getAllCountries()
{
    return Country::get([
        "id",
        "name",
        "full_name"
    ]);
}

function getCountry($id)
{
    return Country::where('id', $id)->first();
}

function getStates($id)
{
    $country = Country::where('id', $id)->first();
    return $country->divisions()->get();
}

function getCities($id)
{
    $model = Division::where('id', $id)->first();

    return $model->children();
}
