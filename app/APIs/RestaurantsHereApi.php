<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class RestaurantsHereApi  implements IApi
{
    private static $instance = null;
    private const appid = "S6Iviy32a-5Vr6RvxxDqSwxUAep2IuC-E53Kl1tmkOM";
    private const endpoint = 'https://places.ls.hereapi.com/places/v1/discover/search';

    //singlton
    public static function getInstance()
    {
        if (is_null(RestaurantsHereApi::$instance)) {
            RestaurantsHereApi::$instance = new RestaurantsHereApi();
        }

        return RestaurantsHereApi::$instance;
    }

    function getRestaurants($latitude, $longitude, $restaurantMinPrice = 0, $restaurantMixPrice = 0)
    {
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Accept' => 'application/json'
            ])
            ->get($this::endpoint, [
                "at" => "$latitude,$longitude",
                'q' => 'restaurant',
                "apiKey" => $this::appid,
            ]);

        return json_decode($res->getBody()->getContents());
    }
}
