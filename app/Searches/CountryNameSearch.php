<?php

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

    function __construct()
    {
        $this->newsApi = NewsApi::getInstance();
        $this->currencyApi = CurrencyApi::getInstance();
    }
    function search()
    {
        $this->newsApi->getNews($this->countryCode);
        $this->currencyApi->convert($this->currencyCode);
    }
}
