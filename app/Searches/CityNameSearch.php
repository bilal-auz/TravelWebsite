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

    function __construct()
    {
        $this->hotelsApi = HotelsApi::getInstance();
        $this->flightsApi = FlightApi::getInstance();
        $this->restaurantsApi = RestaurantsApi::getInstance();
        $this->placeToDiscover = PlaceToDiscover::getInstance();
        $this->weatherApi = WeatherApi::getInstance();
        $this->imagesApi = ImagesApi::getInstance();
    }
    function search()
    {
        $this->hotelsApi->getHotels($this->destinationAirportCode);
        $this->flightsApi->getFlights($this->destinationAirportCode);
        $this->restaurantsApi->getRestaurants($this->cityName);
        $this->placeToDiscover->getRandPlace($this->cityName);
        $this->weatherApi->getWeather($this->cityName);
        $this->imagesApi->getImage($this->cityName);
    }
}
