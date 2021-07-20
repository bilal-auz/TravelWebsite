<?php

namespace App\APIs;


use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class MapQuestApi implements IApi
{
    private static $instance = null;
    private const endpoint = "http://open.mapquestapi.com/geocoding/v1/address";
    private const key = "0e8VbsZmyrA4ueSRAX9qqVgzzaCLU5ze";

    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (is_null(MapQuestApi::$instance)) {
            MapQuestApi::$instance = new MapQuestApi();
        }

        return MapQuestApi::$instance;
    }
    function getPlaceCoords($placeName)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                "location" => $placeName,
                "key" => $this::key
            ]);

        $res = json_decode($res->getBody()->getContents());
        // dd($res->results[0]->locations[0]->latLng);
        return $res->results[0]->locations[0]->latLng;
    }
}
