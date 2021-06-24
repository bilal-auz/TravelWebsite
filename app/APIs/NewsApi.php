<?php

namespace App\APIs;

use App\Lib\IApi;

class NewsApi implements IApi
{
    private static $instance = null;
    private const apiKey = "";
    private const responseLimit = "20";
    private const endPoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(NewsApi::$instance)) {
            NewsApi::$instance = new NewsApi();
        }

        return NewsApi::$instance;
    }

    function getNews(String $countryCode)
    {
    }
}
