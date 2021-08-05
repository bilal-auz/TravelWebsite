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

    function __construct(String $cityName, $cityAirportCodes, $latitude, $longitude, $hotelMinPrice, $hotelMaxPrice, $restaurantMinPrice, $restaurantMixPrice, $placeKeyWord, $flightMinPrice, $flightMaxPrice)
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
        error_log('Hotel API');
        $hotels = $this->getHotels($this->latitude, $this->longitude, $this->hotelMinPrice, $this->hotelMaxPrice);

        error_log('Flight API');
        $flights = $this->getFlights($this->cityAirportCodes, $this->flightMinPrice, $this->flightMaxPrice);

        error_log('Restaurants API');
        $restaurants = $this->getRestaurants($this->latitude, $this->longitude, $this->restaurantMinPrice, $this->restaurantMixPrice);

        error_log('Place API');
        $places = $this->getPlaces($this->cityName, $this->placeKeyWord);

        error_log('weather API');
        $weather = $this->getWeather($this->latitude, $this->longitude);

        error_log('images API');
        $image = $this->getImages($this->cityName . ' town');

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

    private function getHotels($latitude, $longitude, $hotelMinPrice, $hotelMaxPrice)
    {
        return $this->hotelsApi->getHotelsWithPrices($latitude, $longitude, $hotelMinPrice, $hotelMaxPrice);
    }


    private function getFlights($cityAirportCodes, $flightMinPrice, $flightMaxPrice)
    {
        if (is_null($flightMinPrice)) {
            $flightMinPrice = 0;
        }

        if (is_null($flightMaxPrice)) {
            $flightMaxPrice = 999999;
        }

        $flights = [];
        if (!empty($cityAirportCodes)) {
            try {
                foreach ($cityAirportCodes as $code) {
                    $flights = $this->flightsApi->getFlightsWithPrices($code, $flightMinPrice, $flightMaxPrice);

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
                                if ($filght->price->total >= $flightMinPrice) {
                                    array_push($filtered, $filght);
                                }
                            }

                            $flights = $filtered;

                            break;
                        }
                    }
                }
            } catch (Exception $ex) {
                dd($flights);
            } finally {
                // var_dump($flights);
            }
        }

        return $flights;
    }


    private function getRestaurants($latitude, $longitude, $restaurantMinPrice, $restaurantMaxPrice)
    {
        if (is_null($restaurantMinPrice)) {
            $restaurantMinPrice = 0;
        }

        if (is_null($restaurantMaxPrice)) {
            $restaurantMaxPrice = 99999;
        }

        return $this->restaurantsApi->getRestaurants($latitude, $longitude, $restaurantMinPrice, $restaurantMaxPrice);
    }


    private function getPlaces($cityName, $placeKeyWord)
    {
        if (is_null($placeKeyWord)) {
            return $this->placeToDiscover->getRandPlace($cityName);
        }

        return $this->placeToDiscover->getPlacesByLabel($cityName, $placeKeyWord);
    }


    private function getWeather($latitude, $longitude)
    {
        return $this->weatherApi->getWeather($latitude, $longitude);
    }


    private function getImages($cityName)
    {
        return $this->imagesApi->getImage($cityName);
    }


    function getAttributes()
    {
    }
}
