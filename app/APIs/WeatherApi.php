<?php

namespace App\APIs;

use App\Lib\IApi;

class WeatherApi implements IApi
{
    private static $instance = null;
    private const apiKey = "";
    private const endPoint = "";

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
    }
}
