<?php

namespace App\APIs;


use App\Lib\IApi;


class HotelsApi implements IApi
{
    private static $instance = null;
    private const client_id = "";
    private const client_secret = "";
    private const grant_type = "";
    private $token;
    private const currency = "MAD";
    private const tokenEndpoint = "";
    private const hotelsEndpoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(HotelsApi::$instance)) {
            HotelsApi::$instance = new HotelsApi();
        }

        return HotelsApi::$instance;
    }

    function getHotels(String $destinationAirportCode)
    {
        return "Token:" . $this->getToken() . "\nHotels in" . $destinationAirportCode;
    }

    function getHotelsWithPrices(String $destinationAirportCode, int $minPrice, int $maxPrice)
    {
        return "Token:" . $this->getToken() . "\nHotels in" . $destinationAirportCode . ", From:" . $minPrice . " TO:" . $maxPrice;
    }

    private function getToken()
    {
        //dont make new token anleas the the token expired
        return "555222111";
    }
}
