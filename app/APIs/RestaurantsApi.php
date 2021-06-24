<?php

namespace App\APIs;

use App\Lib\IApi;

class RestaurantsApi implements IApi
{
    private static $instance = null;
    private const x_rapidapi_key = "";
    private const x_rapidapi_host = "";
    private const language = "en_US";
    private const currency = "MAD";
    private const responseLimit = "10";
    private const location_Id_Endpoint = "";
    private const restaurantsEndpoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(RestaurantsApi::$instance)) {
            RestaurantsApi::$instance = new RestaurantsApi();
        }

        return RestaurantsApi::$instance;
    }

    function getRestaurants(String $cityName)
    {
    }

    function getRestaurantsWithPrices(String $cityName, int $minPrice, int $maxPrice)
    {
    }

    function getLocationId()
    {
        return "location_Id";
    }
}
