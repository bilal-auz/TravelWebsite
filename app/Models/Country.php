<?php

namespace App\Models;

use App\Lib\ISearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
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

        $searchObj = new CountryNameSearch(
            $countryInfo->country_name,
            $countryInfo->alpha_2_code,
            $countryInfo->currency_code
        );

        $res = $searchObj->search();
        // $res = null;

        $country = [
            "name" => $countryInfo->country_name,
            "capital" => $countryInfo->capital,
            "language" => $countryInfo->lang_name,
            "currencyName" => $countryInfo->currency_name,
            "regionalOrg" => $countryInfo->regional_org,
            "timeZone" => $countryInfo->timezone,
            "continent" => $countryInfo->continent,
            "alphaCode" => $countryInfo->alpha_2_code,
            "cities" => null,
            "news" => $res["news"],
            "currencyRate" => $res["currencyRate"],
        ];

        // dd($country);
        return $country;
    }

    static public function searchByCriteria(ISearch $searchObj)
    {
        $data = $searchObj->getAttributes();

        $countries = Country::where('lang_name', $data['language'])
            ->where('currency_code', $data['currency'])
            ->where('continent', $data['continent'])
            ->get();

        return $countries;
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
