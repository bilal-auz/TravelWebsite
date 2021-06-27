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

    function getWeather(String $cityName)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                "q" => $cityName,
                "appid" => $this::apiKey,
                "units" => 'metric' // for Celsius 
            ]);

        dd($res->getBody()->getContents()); // ->main->temp
    }
}
