<?php

namespace App\Searches;

use App\APIs\HotelsApi;
use App\APIs\FlightApi;
use App\APIs\RestaurantsApi;
use App\APIs\PlaceToDiscover;
use App\APIs\WeatherApi;
use App\APIs\ImagesApi;
use App\APIs\RestaurantsHereApi;
use App\Lib\ISearch;
use Exception;

class CityCriteriaSearch implements ISearch
{
    private $cityName;
    private $cityAirportCodes;
    private $latitude;
    private $longitude;
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

    function __construct(String $cityName, $cityAirportCodes, $latitude, $longitude, String $hotelMinPrice, String $hotelMaxPrice, $restaurantMinPrice, $restaurantMixPrice, String $placeKeyWord, String $flightMinPrice, String $flightMaxPrice)
    {
        $this->cityName = $cityName;
        $this->cityAirportCodes = $cityAirportCodes;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->hotelMinPrice = $hotelMinPrice;
        $this->hotelMaxPrice = $hotelMaxPrice;
        $this->restaurantMinPrice = 0; //default value
        $this->restaurantMixPrice = 0; //default value
        $this->placeKeyWord = $placeKeyWord;
        $this->flightMinPrice = $flightMinPrice;
        $this->flightMaxPrice = $flightMaxPrice;
        $this->hotelsApi = HotelsApi::getInstance();
        $this->flightsApi = FlightApi::getInstance();
        $this->restaurantsApi = RestaurantsHereApi::getInstance();
        $this->placeToDiscover = PlaceToDiscover::getInstance();
        $this->weatherApi = WeatherApi::getInstance();
        $this->imagesApi = ImagesApi::getInstance();
    }

    function search()
    {
        // return "From Search by criteria, calling APIS.." . "cityName=$this->cityName, " . "CityAirportCode = $this->destinationAirportCode";

        error_log('Hotel API');
        $hotels = $this->hotelsApi->getHotelsWithPrices($this->latitude, $this->longitude, $this->hotelMinPrice, $this->hotelMaxPrice);

        error_log('Flight API');
        $flights = [];
        if (!empty($this->cityAirportCodes)) {
            try {
                foreach ($this->cityAirportCodes as $code) {
                    $flights = $this->flightsApi->getFlightsWithPrices($code, $this->flightMinPrice, $this->flightMaxPrice);

                    if (array_key_exists('errors', $flights)) {
                        continue;
                    }

                    if (array_key_exists('meta', $flights)) {
                        if ($flights->meta->count < 1) {
                            continue;
                        }
                        if ($flights->meta->count >= 1) {

                            //manually filtering the by minPrice
                            $filtered = [];
                            foreach ($flights->data as $filght) {
                                if ($filght->price->total >= $this->flightMinPrice) {
                                    array_push($filtered, $filght);
                                }
                            }

                            $flights = $filtered;

                            break;
                        }
                    }
                }
            } catch (Exception $ex) {
                echo $ex;
                dd($flights);
            } finally {
                // var_dump($flights);
            }
        }


        error_log('Restaurants API');
        // Getting Restaurants by prices is Not Avaliable due to API
        $restaurants = $this->restaurantsApi->getRestaurants($this->latitude, $this->longitude, $this->restaurantMinPrice, $this->restaurantMixPrice);

        error_log('Place API');
        $places = $this->placeToDiscover->getPlacesByLabel($this->cityName, $this->placeKeyWord);

        error_log('weather API');
        $weather = $this->weatherApi->getWeather(
            $this->latitude,
            $this->longitude
        );

        error_log('images API');
        $image = $this->imagesApi->getImage($this->cityName . ' town');

        $city = [
            'name' => $this->cityName,
            'airportCode' => $this->cityAirportCodes,
            'hotels' => $hotels,
            'flights' => $flights,
            'restaurants' => $restaurants,
            'places' => $places,
            'weather' => $weather,
            'image' => $image
        ];

        return $city;
    }

    function getAttributes()
    {
    }
}
