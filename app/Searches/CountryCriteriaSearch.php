<?php


namespace App\Searches;

use App\Lib\ISearch;


class CountryCriteriaSearch implements ISearch
{
    private $language;
    private $currency;
    private $continent;

    public function __construct($language, $currency, $continent)
    {
        $this->language = $language;
        $this->currency = $currency;
        $this->continent = $continent;
    }

    //this its not used for now, till we need to use an API
    function search()
    {
    }

    function getAttributes()
    {
        return [
            "language" => $this->language,
            "currency" => $this->currency,
            "continent" => $this->continent
        ];
    }
}
