<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class CurrencyApi implements IApi
{
    private static $instance = null;
    private const toCurrency = "MAD";
    private const amount = "1";
    private const endPoint = "https://api.exchangerate.host/convert";

    //singlton
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(CurrencyApi::$instance)) {
            CurrencyApi::$instance = new CurrencyApi();
        }

        return CurrencyApi::$instance;
    }

    function convert(String $fromCurrency)
    {
        $res = Http::withOptions(['verify' => false])->get($this::endPoint, [
            'from' => $fromCurrency,
            'to' => $this::toCurrency,
            'amount' => $this::amount
        ]);
        $res = json_decode($res->getBody()->getContents());
        $response = [
            "query" => $res->query,
            "result" => $res->result
        ];
        return ($response); //$res->result
    }
}
