<?php

namespace App\Searches;

use App\APIs\HotelsApi;
use App\APIs\FlightApi;
use App\APIs\RestaurantsApi;
use App\APIs\PlaceToDiscover;
use App\APIs\WeatherApi;
use App\APIs\ImagesApi;

use App\Lib\ISearch;

class CityNameSearch implements ISearch
{
    private $cityName;
    private $cityAirportCode;
    private $hotelsApi;
    private $flightsApi;
    private $restaurantsApi;
    private $placeToDiscover;
    private $weatherApi;
    private $imagesApi;

    function __construct(String $cityName, String $cityAirportCode)
    {
        $this->cityName = $cityName;
        $this->cityAirportCode = $cityAirportCode;
        $this->hotelsApi = HotelsApi::getInstance();
        $this->flightsApi = FlightApi::getInstance();
        $this->restaurantsApi = RestaurantsApi::getInstance();
        $this->placeToDiscover = PlaceToDiscover::getInstance();
        $this->weatherApi = WeatherApi::getInstance();
        $this->imagesApi = ImagesApi::getInstance();
    }

    function search()
    {
        return "From Search by name, calling APIS.." . "cityName=$this->cityName, " . "CityAirportCode = $this->cityAirportCode";
        $this->hotelsApi->getHotels($this->cityAirportCode);
        $this->flightsApi->getFlights($this->cityAirportCode);
        $this->restaurantsApi->getRestaurants($this->cityName);
        $this->placeToDiscover->getRandPlace($this->cityName);
        $this->weatherApi->getWeather($this->cityName);
        $this->imagesApi->getImage($this->cityName);
    }

    function getAttributes()
    {
    }
}
