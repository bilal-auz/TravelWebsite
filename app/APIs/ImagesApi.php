<?php

namespace App\APIs;

use App\Lib\IApi;

class ImagesApi implements IApi
{
    private static $instance = null;
    private const apiKey = "";
    private const responseLimit = "1";
    private const endPoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(ImagesApi::$instance)) {
            ImagesApi::$instance = new ImagesApi();
        }

        return ImagesApi::$instance;
    }

    function getImage(String $cityName)
    {
    }
}
