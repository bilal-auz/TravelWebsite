<?php

namespace App\Models;

use App\Lib\ISearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use CountryNameSearch;

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

    static public function searchByName(String $countryName, ISearch $searchObj)
    {
        $countryInfo = Country::where('country_name', $countryName)->get()->first();
        $res = $searchObj->search();
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
        // $country['name'] = $countryInfo->country_name;
        // $country['capital'] = $countryInfo->capital;
        // $country['language'] = $countryInfo->lang_name;
        // $country['currencyName'] = $countryInfo->currency_name;
        // $country['regionalOrg'] = $countryInfo->regional_org;
        // $country['timeZone'] = $countryInfo->timezone;
        // $country['continent'] = $countryInfo->continent;
        // $country['alphaCode'] = $countryInfo->alpha_2_code;
        // $country['news'] = $res["news"];
        // $country['currencyRate'] = $res["currencyRate"];

        return $country;
    }
    static public function searchByCriteria(ISearch $searchObj)
    {
        $data = $searchObj->getAttributes();

        $res = Country::where('lang_name', $data['language'])->where('currency_code', $data['currency'])->where('continent', $data['continent'])->get();

        return $res;
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
