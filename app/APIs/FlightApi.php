<?php

namespace App\APIs;


use App\Lib\IApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class FlightApi implements IApi
{
    private static $instance = null;
    private const client_id = "dPwzHQ75xSsF9DUAZI8dhs2MYGznfoKc";
    private const client_secret = "HAkzeHOVcX0kJhd9";
    private const grant_type = "client_credentials";
    private $token = null;
    private $tokenExpireDate = null;
    private const originLocationCode = "CMN";
    private const currency = "MAD";
    private const tokenEndpoint = "https://test.api.amadeus.com/v1/security/oauth2/token";
    private const flightEndpoint = "https://test.api.amadeus.com/v2/shopping/flight-offers";

    private function __construct()
    {
    }

    //singlton
    public static function getInstance()
    {
        if (is_null(FlightApi::$instance)) {
            FlightApi::$instance = new FlightApi();
        }

        return FlightApi::$instance;
    }

    function getFlights($destinationAirportCode)
    {
        // echo "FLight API";

        $res = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken()
        ])->get($this::flightEndpoint, [
            'originLocationCode' => $this::originLocationCode,
            'destinationLocationCode' => $destinationAirportCode,
            'departureDate' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'adults' => '1',
            'currencyCode' => $this::currency
        ]);
        $res = json_decode($res->getBody()->getContents());



        return ($res);
    }

    function getFlightsWithPrices($destinationAirportCode, $minPrice, $maxPrice)
    {
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken()
            ])
            ->get($this::flightEndpoint, [
                'originLocationCode' => $this::originLocationCode,
                'destinationLocationCode' => $destinationAirportCode,
                'departureDate' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'adults' => '1',
                'currencyCode' => $this::currency,
                'maxPrice' => $maxPrice,
                // 'max' => 10 //flights returns
                #should do min price manually
            ]);

        $res = json_decode($res->getBody()->getContents());


        // dd($res->data[0]);

        // dd($filtered);

        return $res;
    }

    //setters & getters
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
        $newTokenResponse = Http::withOptions(['verify' => false])->asForm()->post($this::tokenEndpoint, [
            'grant_type' => $this::grant_type,
            'client_secret' => $this::client_secret,
            'client_id' => $this::client_id
        ]);

        $newTokenResponse =  json_decode($newTokenResponse->getBody()->getContents());

        $this->token = $newTokenResponse->access_token;
        $this->tokenExpireDate = Carbon::now()->addSeconds($newTokenResponse->expires_in);

        // dd($this->token . " in " . $this->tokenExpireDate);
    }
}
