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
        // $this->hotelsApi->getHotelsWithPrices($this->destinationAirportCode, $this->hotelMinPrice, $this->hotelMaxPrice);
        // $this->flightsApi->getFlightsWithPrices($this->destinationAirportCode, $this->flightMinPrice, $this->flightMaxPrice);
        // $this->restaurantsApi->getRestaurantsByPrices($this->cityName, $this->restaurantMinPrice, $this->restaurantMixPrice);
        // $this->placeToDiscover->getPlacesByLabel($this->cityName, $this->placeKeyWord);
        // $this->weatherApi->getWeather($this->cityName);
        // $this->imagesApi->getImage($this->cityName);
        return  $this->hotelsApi->getHotelsWithPrices($this->destinationAirportCode, $this->hotelMinPrice, $this->hotelMaxPrice);
    }

    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
    }

    public function setDestinationAirportCode($destinationAirportCode)
    {
        $this->destinationAirportCode = $destinationAirportCode;
    }

    public function setHotelMinPrice($hotelMinPrice)
    {
        $this->hotelMinPrice = $hotelMinPrice;
    }

    public function setHotelMaxPrice($hotelMaxPrice)
    {
        $this->hotelMaxPrice = $hotelMaxPrice;
    }

    public function setRestaurantMinPrice($restaurantMinPrice)
    {
        $this->restaurantMinPrice = $restaurantMinPrice;
    }

    public function setRestaurantMixPrice($restaurantMixPrice)
    {
        $this->restaurantMixPrice = $restaurantMixPrice;
    }

    public function setPlaceKeyWord($placeKeyWord)
    {
        $this->placeKeyWord = $placeKeyWord;
    }

    public function setFlightMinPrice($flightMinPrice)
    {
        $this->flightMinPrice = $flightMinPrice;
    }

    public function setFlightMaxPrice($flightMaxPrice)
    {
        $this->flightMaxPrice = $flightMaxPrice;
    }
}
