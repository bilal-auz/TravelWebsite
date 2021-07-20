<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class WeatherApi implements IApi
{
    private static $instance = null;
    private const apiKey = "48282aa163f7cb3c6a389d17be35172b";
    private const endpoint = "https://api.openweathermap.org/data/2.5/weather";

    //singlton
    public static function getInstance()
    {
        if (is_null(WeatherApi::$instance)) {
            WeatherApi::$instance = new WeatherApi();
        }

        return WeatherApi::$instance;
    }

    function getWeather($latitude, $longitude)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                // "q" => $cityName,
                "lat" => $latitude,
                "lon" => $longitude,
                "appid" => $this::apiKey,
                "units" => 'metric' // for Celsius 
            ]);

        $res = json_decode($res->getBody()->getContents());
        $res->main->temp = explode(".", $res->main->temp, 99)[0];
        // return json_decode($res->getBody()->getContents()); // ->main->temp
        return $res;
    }

    // function getCityCoords($cityName)
    // {
    //     $res = $this->getWeather($cityName);
    //     $coord = [
    //         'lat' => $res->coord->lat,
    //         'lon' => $res->coord->lon
    //     ];

    //     return $coord;
    // }
}
