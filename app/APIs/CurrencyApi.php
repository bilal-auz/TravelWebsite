<?php

namespace App\APIs;

use App\Lib\IApi;

class CurrencyApi implements IApi
{
    private static $instance = null;
    private const toCurrency = "MAD";
    private const amount = "1";
    private const endPoint = "";

    //singlton
    public static function getInstance()
    {
        if (is_null(CurrencyApi::$instance)) {
            CurrencyApi::$instance = new CurrencyApi();
        }

        return CurrencyApi::$instance;
    }

    function convert(String $fromCurrency)
    {
    }
}
