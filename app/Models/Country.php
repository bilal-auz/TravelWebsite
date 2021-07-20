<?php

namespace App\Models;

use App\Lib\ISearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\Reviews\Country as ReviewsCountry;
use App\Searches\CountryNameSearch;

class Country extends Model
{
    // use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'country';
    protected $primarykey = 'alpha_2_code';

    static public function getCountryInfo($countryName)
    {
        $country = Country::where('country_name', $countryName)->get()->first();
        // dd($country);
        return $country;
    }

    static public function searchByName($countryName)
    {
        $countryInfo = Country::where('country_name', $countryName)->get()->first();

        $reviews = ReviewsCountry::getCountryReviews($countryInfo->alpha_2_code);

        // $cities = City::getCitiesInCountry("united states");
        $cities = $countryInfo->cities();

        $searchObj = new CountryNameSearch(
            $countryInfo->country_name,
            $countryInfo->alpha_2_code,
            $countryInfo->currency_code
        );

        $res = $searchObj->search();
        // $res = null;

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

        $countries = Country::SELECT('country_name')
            ->where('lang_name', $data['language'])
            ->where('currency_code', $data['currency'])
            ->where('continent', $data['continent'])
            ->orderBy('country_name', 'ASC')
            ->get();

        return $countries;
    }

    public function cities()
    {
        $cities = $this->hasMany(City::class, 'country_name', 'country_name');
        return $cities->take(50)->get();
    }
}
