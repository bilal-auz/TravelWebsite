<?php

use App\Lib\IApi;

class HotelsApi implements IApi
{
    private const client_id = "";
    private const client_secret = "";
    private const grant_type = "";
    private $token;
    private const currency = "MAD";
    private const tokenEndpoint = "";
    private const hotelsEndpoint = "";

    function getHotels(String $destinationAirportCode)
    {
    }

    function getHotelsWithPrices(String $destinationAirportCode, int $minPrice, int $maxPrice)
    {
    }

    private function getToken()
    {
        //dont make new token anleas the the token expired
        return "token";
    }
}
