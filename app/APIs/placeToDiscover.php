<?php

namespace App\APIs;


use App\Lib\IApi;

class PlaceToDiscover implements IApi
{
    private static $instance = null;
    private const x_Triposo_Account = "";
    private const x_Triposo_Token = "";
    private const responseLimit = "10";
    private const randPlaceEndpoint = "";
    private const specificPlaceEndpoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(PlaceToDiscover::$instance)) {
            PlaceToDiscover::$instance = new PlaceToDiscover();
        }

        return PlaceToDiscover::$instance;
    }

    function getRandPlace(String $cityName)
    {
    }

    function getPlacesByLabel()
    {
    }
}
