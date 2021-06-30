<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Lib\ISearch;
use App\Searches\CityNameSearch;

class City extends Model
{
    // use HasFactory;
    protected $connetion = 'mysql';
    protected $table = 'cityAirport';
    protected $primarykey = 'id';

    static function getCityInfo($cityName)
    {
        $cityInfo = City::where('city_name', $cityName)
            ->get()
            ->first();

        return $cityInfo;
    }
    static public function searchByName($cityName)
    {
        $cityInfo = City::getCityInfo($cityName);
        // dd($cityInfo->airport_code_iata);
        $searchObj = new CityNameSearch(
            $cityInfo->city_name,
            $cityInfo->airport_code_iata
        );

        $city = $searchObj->search();

        return $city;
    }

    static public function searchByCriteria(ISearch $searchObj)
    {
        $res = $searchObj->search();
        return $res;
    }

    static public function getCityAirportCode(String $cityName)
    {
        // !!some cities got more than one airport, we can use them as backup if the API couldn't find the city
        $airports = City::where('city_name', $cityName)->get()->first();
        return $airports->airport_code_iata;
        $x = [];
        foreach ($airports as $airportCode) {
            array_push($x, $airportCode->airport_code_iata);
        }
        return $x;
        // dd($x);
    }
}
