<?php


use App\Lib\IApi;

class FlightApi implements IApi
{
    private const client_id = "";
    private const client_secret = "";
    private $token = null;
    private const originLocationCode = "CMN";
    private const currency = "MAD";
    private const TokenEnpoint = "";
    private const FlightEndpoint = "";

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
