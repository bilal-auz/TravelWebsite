<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

// SEARCHES
use App\Lib\ISearch;
use App\Searches\CountryNameSearch;

// Models
use App\Models\City;
use App\Models\Reviews\Country as ReviewsCountry;

class Country extends Model
{
    // use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'country';
    protected $primarykey = 'alpha_2_code';

    static public function getCountryInfo($countryName)
    {
        $country = Country::where('country_name', $countryName)->get()->first();

        return $country;
    }

    static public function searchByName($countryName)
    {
        $countryInfo = Country::where('country_name', $countryName)->get()->first();

        $reviews = ReviewsCountry::getCountryReviews($countryInfo->alpha_2_code);

        $cities = $countryInfo->cities();

        $searchObj = new CountryNameSearch(
            $countryInfo->country_name,
            $countryInfo->alpha_2_code,
            $countryInfo->currency_code
        );

        $res = $searchObj->search();

        $country = [
            "Flag" => $res["flagImage"],
            "name" => $countryInfo->country_name,
            "capital" => $countryInfo->capital,
            "language" => $countryInfo->lang_name,
            "currencyName" => $countryInfo->currency_name,
            "currencyCode" => $countryInfo->currency_code,
            "regionalOrg" => $countryInfo->regional_org,
            "timeZone" => $countryInfo->timezone,
            "continent" => $countryInfo->continent,
            "alphaCode" => $countryInfo->alpha_2_code,
            "cities" => $cities,
            "news" => $res["news"],
            "currencyConvert" => $res["currencyConvert"],
            "reviews" => $reviews
        ];

        return $country;
    }

    static public function searchByCriteria(ISearch $searchObj)
    {
        $data = $searchObj->getAttributes();

        /** NEXT IF-ELSE Explanation
         * 
         * if the input is null(empty)
         * the value gets the same column name to return everything = WHERE 1+1
         * 
         * NOTE: the value cant be single quoted it should be the exact same name of the column
         * 
         * else if the input is filled the single quotes added to the value(its query string rule)
         * 
         */
        if (is_null($data['language'])) {
            $lang = 'lang_name';
        } else {
            $lang = "'" . $data['language'] . "'";
        }

        if (is_null($data['currency'])) {
            $currency = 'currency_code';
        } else {
            $currency = "'" .  $data['currency'] . "'";
        }

        if (is_null($data['continent'])) {
            $continent = 'continent';
        } else {
            $continent = "'" . $data['continent'] . "'";
        }


        // dd($data);
        $query = "SELECT country_name FROM country WHERE lang_name =" . $lang . " AND currency_code =" . $currency . " AND continent =" . $continent . " ORDER BY country_name ASC";

        $countries = DB::SELECT($query);

        // $countries = Country::SELECT('country_name')
        //     ->WHERE('lang_name', $data['language'])
        //     ->WHERE('currency_code', $data['currency'])
        //     ->WHERE('continent', $data['continent'])
        //     ->orderBy('country_name', 'ASC')
        //     ->get();

        return $countries;
    }

    public function cities()
    {
        $cities = $this->hasMany(City::class, 'country_name', 'country_name');
        return $cities->take(50)->get();
    }
}
