<?php

namespace App\APIs;


use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class PlaceToDiscover implements IApi
{
    private static $instance = null;
    private const x_Triposo_Account = "Q8VJHRAV";
    private const x_Triposo_Token = "5uk7h97nr3vrat1bprc17m2h6gha68d8";
    private const responseLimit = "10";
    private const endpoint = "https://www.triposo.com/api/20210317/poi.json";

    //singlton
    public static function getInstance()
    {
        if (is_null(PlaceToDiscover::$instance)) {
            PlaceToDiscover::$instance = new PlaceToDiscover();
        }

        return PlaceToDiscover::$instance;
    }

    function getRandPlace(String $cityName)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                'location_id' => $cityName,
                'count' => $this->reponseLimit,
                'fields' => "id,name,score,intro,location_id,location_ids",
                'order_by' => "-score"
            ]);

        dd($res->getBody->getContenet()); // ->results[0]->name
    }

    function getPlacesByLabel(String $cityName, String $label)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                'location_id' => $cityName,
                'count' => $this->reponseLimit,
                'tag_labels' => $label,
                'fields' => "id,name,score,intro,tag_labels,location_id,location_ids",
                'order_by' => "-score"
            ]);

        dd($res->getBody->getContenet()); // ->results[0]->name, ->results[0]->intro
    }
}
