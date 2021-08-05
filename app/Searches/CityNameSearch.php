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
use Illuminate\Support\Facades\Http;

class CityNameSearch implements ISearch
{
    private $cityName;
    private $cityAirportCodes;
    private $latitude;
    private $longitude;
    private $hotelsApi;
    private $flightsApi;
    private $restaurantsApi;
    private $placeToDiscover;
    private $weatherApi;
    private $imagesApi;

    function __construct(String $cityName, $airportCodes, $latitude, $longitude)
    {
        $this->cityName = $cityName;
        $this->cityAirportCodes = $airportCodes;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->hotelsApi = HotelsApi::getInstance();
        $this->flightsApi = FlightApi::getInstance();
        // $this->restaurantsApi = RestaurantsApi::getInstance();
        $this->restaurantsApi = RestaurantsHereApi::getInstance();
        $this->placeToDiscover = PlaceToDiscover::getInstance();
        $this->weatherApi = WeatherApi::getInstance();
        $this->imagesApi = ImagesApi::getInstance();
    }

    function search()
    {
        error_log('Searching...');

        error_log('Hotel API');
        $hotels = $this->getHotels($this->latitude, $this->longitude);

        error_log('Flight API');
        $flights = $this->getFlights($this->cityAirportCodes);

        error_log('Restaurants API');
        $restaurants = $this->getRestaurants($this->latitude, $this->longitude);


        error_log('Place API');
        $places = $this->getPlaces($this->cityName);

        error_log('weather API');
        $weather = $this->getWeather($this->latitude, $this->longitude);

        error_log('images API');
        $image = $this->getImages($this->cityName);

        $city = [
            'name' => $this->cityName,
            'airportCode' => $this->cityAirportCodes,
            'hotels' => $hotels,
            'flights' => $flights,
            'restaurants' => $restaurants,
            'places' => $places,
            'weather' => $weather,
            'image' => $image,
        ];

        return $city;
    }

    private function getHotels($latitude, $longitude)
    {
        return $this->hotelsApi->getHotels($latitude, $longitude);
    }


    private function getFlights($cityAirportCodes)
    {
        $flights = [];
        if (!empty($cityAirportCodes)) {
            try {
                foreach ($cityAirportCodes as $code) {
                    $flights = $this->flightsApi->getFlights($code);

                    if (array_key_exists('errors', $flights)) {
                        continue;
                    }

                    if (array_key_exists('meta', $flights)) {
                        if ($flights->meta->count < 1) {
                            continue;
                        }
                        if ($flights->meta->count >= 1) {
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


    private function getRestaurants($latitude, $longitude)
    {
        return $this->restaurantsApi->getRestaurants($latitude, $longitude);
    }


    private function getPlaces($cityName)
    {
        return $this->placeToDiscover->getRandPlace($cityName);
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
