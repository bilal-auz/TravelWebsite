<?php

namespace App\Searches;

use App\APIs\HotelsApi;
use App\APIs\FlightApi;
use App\APIs\RestaurantsApi;
use App\APIs\PlaceToDiscover;
use App\APIs\WeatherApi;
use App\APIs\ImagesApi;

use App\Lib\ISearch;

class CityCriteriaSearch implements ISearch
{
    private $cityName;
    private $destinationAirportCode;
    private $hotelMinPrice;
    private $hotelMaxPrice;
    private $restaurantMinPrice;
    private $restaurantMixPrice;
    private $placeKeyWord;
    private $flightMinPrice;
    private $flightMaxPrice;
    private $hotelsApi;
    private $flightsApi;
    private $restaurantsApi;
    private $placeToDiscover;
    private $weatherApi;
    private $imagesApi;

    function __construct(String $cityName, String $destinationAirportCode, String $hotelMinPrice, String $hotelMaxPrice, String $restaurantMinPrice, String $restaurantMixPrice, String $placeKeyWord, String $flightMinPrice, String $flightMaxPrice)
    {
        $this->cityName = $cityName;
        $this->destinationAirportCode = $destinationAirportCode;
        $this->hotelMinPrice = $hotelMinPrice;
        $this->hotelMaxPrice = $hotelMaxPrice;
        $this->restaurantMinPrice = $restaurantMinPrice;
        $this->restaurantMixPrice = $restaurantMixPrice;
        $this->placeKeyWord = $placeKeyWord;
        $this->flightMinPrice = $flightMinPrice;
        $this->flightMaxPrice = $flightMaxPrice;
        $this->hotelsApi = HotelsApi::getInstance();
        $this->flightsApi = FlightApi::getInstance();
        $this->restaurantsApi = RestaurantsApi::getInstance();
        $this->placeToDiscover = PlaceToDiscover::getInstance();
        $this->weatherApi = WeatherApi::getInstance();
        $this->imagesApi = ImagesApi::getInstance();
    }

    function search()
    {
        return "From Search by criteria, calling APIS.." . "cityName=$this->cityName, " . "CityAirportCode = $this->destinationAirportCode";
        $this->hotelsApi->getHotelsWithPrices($this->destinationAirportCode, $this->hotelMinPrice, $this->hotelMaxPrice);
        $this->flightsApi->getFlightsWithPrices($this->destinationAirportCode, $this->flightMinPrice, $this->flightMaxPrice);
        $this->restaurantsApi->getRestaurantsByPrices($this->cityName, $this->restaurantMinPrice, $this->restaurantMixPrice);
        $this->placeToDiscover->getPlacesByLabel($this->cityName, $this->placeKeyWord);
        $this->weatherApi->getWeather($this->cityName);
        $this->imagesApi->getImage($this->cityName);
    }

    function getAttributes()
    {
    }
}
