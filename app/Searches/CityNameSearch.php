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

        // return "From Search by name, calling APIS.." . "cityName=$this->cityName, " . "CityAirportCode = $this->cityAirportCode";

        // $hotels = $this->hotelsApi->getHotels($this->cityAirportCode);

        error_log('Hotel API');
        $hotels = $this->hotelsApi->getHotels($this->cityAirportCodes[0], $this->latitude, $this->longitude);

        error_log('Flight API');
        $flights = '';
        try {
            foreach ($this->cityAirportCodes as $code) {
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

        // $restaurants = $this->restaurantsApi->getRestaurants($this->cityName);
        error_log('Restaurants API');
        $restaurants = $this->restaurantsApi->getRestaurants($this->latitude, $this->longitude);

        error_log('Place API');
        $places = $this->placeToDiscover->getRandPlace($this->cityName);

        error_log('weather API');
        $weather = $this->weatherApi->getWeather(
            $this->latitude,
            $this->longitude
        );

        error_log('images API');
        $image = $this->imagesApi->getImage($this->cityName);

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

    function getAttributes()
    {
    }
}
