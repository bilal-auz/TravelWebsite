<?php

namespace App\Models;

use App\APIs\MapQuestApi;
use App\APIs\WeatherApi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Lib\ISearch;
use App\Searches\CityNameSearch;
use App\Models\Reviews\City as CityReviews;
use Carbon\Carbon;

class City extends Model
{
    // use HasFactory;
    protected $connetion = 'mysql';
    protected $table = 'cityAirport';
    protected $primarykey = 'id';
    private static $limit = 50;

    static function getCitiesInCountry($countryName)
    {
        $cities = City::SELECT('city_name')
            ->WHERE('country_name', $countryName)
            ->groupBy('city_name')
            ->take(City::$limit)
            ->get()
            ->map
            ->only(['city_name']);

        // dd($cities);

        return $cities;
    }
    static function getCityAirportCodes($cityName)
    {
        $cityInfo = City::where('city_name', $cityName)
            ->Where('airport_code_iata', '!=', "\\N")
            ->get();

        $airportCodes = [];

        foreach ($cityInfo as $city) {
            array_push($airportCodes, $city->airport_code_iata);
        }

        return $airportCodes;
    }

    static function getCityCoords($cityName)
    {
        $mapQuestApi = MapQuestApi::getInstance();

        $coords = $mapQuestApi->getPlaceCoords($cityName);

        return $coords;
    }

    static public function searchByName($cityName)
    {
        $airportCodes = City::getCityAirportCodes($cityName);

        $coords = City::getCityCoords($cityName);

        $reviews = CityReviews::getCityReviews($cityName);

        $searchObj = new CityNameSearch(
            $cityName,
            $airportCodes,
            $coords->lat,
            $coords->lng
        );

        $city = $searchObj->search();

        $city['reviews'] = $reviews;

        // dd($city['reviews'][0]["created_at"]->toDateTime()->format("H:i"), $city['reviews'][0]["created_at"]->toDateTime()->format("d/m/Y"));

        return $city;
    }

    static public function searchByCriteria(ISearch $searchObj)
    {
        $res = $searchObj->search();

        return $res;
    }
}
