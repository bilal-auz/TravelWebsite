<?php

use App\Lib\ISearch;

class CountryCriteriaSearch implements ISearch
{
    private $language;
    private $currency;
    private $continent;

    //this its not used for now, till we need to use an API
    function search()
    {
    }
}
