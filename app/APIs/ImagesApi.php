<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class ImagesApi implements IApi
{
    private static $instance = null;
    private const apiKey = "yMg5RU9W7L8auvX5oHbIWdZ0NW8OyXmPyaisQpesONk";
    private $responseLimit = "50";
    private const endpoint = "https://api.unsplash.com/search/photos";

    //singlton
    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (is_null(ImagesApi::$instance)) {
            ImagesApi::$instance = new ImagesApi();
        }

        return ImagesApi::$instance;
    }

    function getImage(String $cityName)
    {
        $res = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Client-ID ' . $this::apiKey
            ])->get($this::endpoint, [
                'page' => 1,
                'query' => $cityName,
                'per_page' => $this->responseLimit,
                "order_by" => "relevant"
            ]);

        $images = json_decode($res->getBody()->getContents());

        $images->randomIndex = random_int(0, count($images->results) / 2);

        return $images; //->results[0]->urls->small, link for the photos
    }
}
