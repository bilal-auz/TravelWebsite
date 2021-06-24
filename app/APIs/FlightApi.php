<?php

namespace App\APIs;


use App\Lib\IApi;

class FlightApi implements IApi
{
    private static $instance = null;
    private const client_id = "";
    private const client_secret = "";
    private $token = null;
    private const originLocationCode = "CMN";
    private const currency = "MAD";
    private const TokenEnpoint = "";
    private const FlightEndpoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(FlightApi::$instance)) {
            FlightApi::$instance = new FlightApi();
        }

        return FlightApi::$instance;
    }

    function getFlights(String $destinationAirportCode)
    {
    }

    function getFlightsWithPrice(String $destinationAirportCode, int $minPrice, int $maxPrice)
    {
    }

    function getToken()
    {
        return "Token";
    }
}
