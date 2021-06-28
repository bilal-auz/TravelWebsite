<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Lib\ISearch;

class City extends Model
{
    // use HasFactory;
    protected $connetion = 'mysql';
    protected $table = 'cityAirport';
    protected $primarykey = 'id';

    static public function searchByName(ISearch $searchObj)
    {
        // $city = City::where('city_name', $searchObj->cityName)->get();
        $res = $searchObj->search();
        return $res;
    }

    static public function searchByCriteria(ISearch $searchObj)
    {
        $res = $searchObj->search();
        return $res;
    }

    static public function getCityAirportCode(String $cityName)
    {
        // !!some cities got more than one airport, we can use them as backup if the API couldn't find the city
        $airports = City::where('city_name', $cityName)->get();
        $x = [];
        foreach ($airports as $airportCode) {
            array_push($x, $airportCode->airport_code_iata);
        }
        return $x;
        // dd($x);
    }
}
