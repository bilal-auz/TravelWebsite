<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class RestaurantsApi implements IApi
{
    private static $instance = null;
    private const x_rapidapi_key = "bb37756420mshdde3ee0c9187e43p1129ccjsn9966c49965ca";
    private const x_rapidapi_host = "worldwide-restaurants.p.rapidapi.com";
    private const language = "en_US";
    private const currency = "MAD";
    private const responseLimit = "10";
    private const location_Id_Endpoint = "https://worldwide-restaurants.p.rapidapi.com/typeahead";
    private const restaurantsEndpoint = "https://worldwide-restaurants.p.rapidapi.com/search";

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
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                "x-rapidapi-key" => $this::x_rapidapi_key,
                "x-rapidapi-host" => $this::x_rapidapi_host
            ])
            ->asForm()
            ->post($this::restaurantsEndpoint, [
                'location_id' => $this->getLocationId($cityName),
                'language' => $this::language,
                'currency' => $this::currency,
                'limit' => $this::responseLimit
            ]);

        dd($res->getBody()->getContents()); //->results->data[0]->name, ->results->data[0]->price("MAD 89 - MAD 133") not fixed
    }

    function getRestaurantsWithPrices(String $cityName, int $minPrice, int $maxPrice)
    {
        #--  this method will only filter the the normal response  --# 

        // $restaurants = $this->getRestaurants($cityName);
        $restaurants = json_decode(file_get_contents(public_path() . '\ApiResponses\Restaturants_response.json'), true);
        // dd($restaurants->getBody()->getContents());
        dd($restaurants['results']['data']);
        //filtering by the price

        #return filterd_hotels
    }

    function getLocationId(String $cityName)
    {
        $res = Http::withOptions(['verify' => false])
            ->asForm()
            ->withHeaders([
                "x-rapidapi-key" => $this::x_rapidapi_key,
                "x-rapidapi-host" => $this::x_rapidapi_host
            ])
            ->post($this::location_Id_Endpoint, [
                "q" => $cityName,
                "language" => $this::language
            ]);

        $res = json_decode($res->getBody()->getContents());
        return $res->results->data[0]->result_object->location_id; //->results->data[0]->result_object->location_id
    }
}
