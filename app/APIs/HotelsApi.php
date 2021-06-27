<?php

namespace App\APIs;


use App\Lib\IApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class HotelsApi implements IApi
{
    private static $instance = null;
    private const client_id = "dPwzHQ75xSsF9DUAZI8dhs2MYGznfoKc";
    private const client_secret = "HAkzeHOVcX0kJhd9";
    private const grant_type = "client_credentials";
    private $token = null;
    private $tokenExpireDate = null;
    private const currency = "MAD";
    private const tokenEndpoint = "https://test.api.amadeus.com/v1/security/oauth2/token";
    private const hotelsEndpoint = "https://test.api.amadeus.com/v2/shopping/hotel-offers";

    //singlton
    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (is_null(HotelsApi::$instance)) {
            HotelsApi::$instance = new HotelsApi();
        }

        return HotelsApi::$instance;
    }

    function getHotels(String $destinationAirportCode)
    {
        // return "Token:" . $this->getToken() . "\nHotels in" . $destinationAirportCode;
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->get($this::hotelsEndpoint, [
                'cityCode' => $destinationAirportCode,
                'roomQuantity' => 1,
                'adults' => 2,
                'radius' => 5,
                'radiusUnit' => "KM",
                'paymentPolicy' => "NONE",
                'includeClosed' => false,
                'bestRateOnly' => true,
                'view' => "FULL",
                'sort' => "NONE"
            ]);

        dd(json_decode($res->getBody()->getContents()));
    }

    function getHotelsWithPrices(String $destinationAirportCode, int $minPrice, int $maxPrice)
    {
        // return "Token:" . $this->getToken() . "\nHotels in" . $destinationAirportCode . ", From:" . $minPrice . " TO:" . $maxPrice;
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->get($this::hotelsEndpoint, [
                'cityCode' => $destinationAirportCode,
                'roomQuantity' => 1,
                'adults' => 2,
                'radius' => 5,
                'radiusUnit' => "KM",
                'paymentPolicy' => "NONE",
                'includeClosed' => false,
                'bestRateOnly' => true,
                'view' => "FULL",
                'sort' => "NONE",
                'priceRange' => $minPrice . '-' . $maxPrice
            ]);

        dd(json_decode($res->getBody()->getContents()));
    }


    //setter&getter for token
    private function getToken()
    {
        //new token if it hasn't been initlized yet OR the expired
        if (is_null($this->token) || Carbon::now()->gt($this->tokenExpireDate)) {
            $this->setToken();
        }

        return $this->token;
    }

    private function setToken()
    {
        $newToken = Http::withOptions(['verify' => false])->asForm()->post($this::tokenEndpoint, [
            'grant_type' => $this::grant_type,
            'client_secret' => $this::client_secret,
            'client_id' => $this::client_id
        ]);

        $newToken =  json_decode($newToken->getBody()->getContents());

        $this->token = $newToken->access_token;
        $this->tokenExpireDate = Carbon::now()->addSeconds($newToken->expires_in); //exortion time = now time + lifeTime of token

        // dd($this->token . " in " . $this->tokenExpireDate);
    }
}
