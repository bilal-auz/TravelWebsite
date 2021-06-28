<?php

namespace App\Searches;

use App\APIs\CurrencyApi;
use App\APIs\NewsApi;
use App\Lib\ISearch;

class CountryNameSearch implements ISearch
{
    private $countryName;
    private $countryCode;
    private $currencyCode;
    private $newsApi;
    private $currencyApi;

    function __construct($countryName, $countryCode, $currencyCode)
    {
        $this->countryName = $countryName;
        $this->countryCode = $countryCode;
        $this->currencyCode = $currencyCode;

        $this->newsApi = NewsApi::getInstance();
        $this->currencyApi = CurrencyApi::getInstance();
    }
    function search()
    {
        $data = [];
        $data["news"] = $this->newsApi->getNews($this->countryCode);
        $data["currencyRate"] = $this->currencyApi->convert($this->currencyCode);
        return $data;
        // dd($data);
    }

    function getAttributes()
    {
    }
}
