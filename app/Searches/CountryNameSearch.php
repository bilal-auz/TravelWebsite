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
        // $data["news"] = $this->newsApi->getNews($this->countryCode);
        $data["news"] = $this->getNews($this->countryCode);

        // $data["currencyConvert"] = $this->currencyApi->convert($this->currencyCode);
        $data["currencyConvert"] = $this->getCurrency($this->currencyCode);

        $data['flagImage'] = null;
        return $data;
        // dd($data);
    }

    private function getNews($countryCode)
    {
        return $this->newsApi->getNews($countryCode);
    }

    private function getCurrency($currencyCode)
    {
        return $this->currencyApi->convert($currencyCode);
    }


    function getAttributes()
    {
        return [
            'countryName' => $this->countryName,
            'countryCode' => $this->countryCode,
            'currencyCode' => $this->currencyCode
        ];
    }
}
