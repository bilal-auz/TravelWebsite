<?php

namespace App\APIs;

use App\Lib\IApi;
use Illuminate\Support\Facades\Http;

class NewsApi implements IApi
{
    private static $instance = null;
    private const apiKey = "8bd01a98898c250739f514ac7d902627";
    private const responseLimit = "20";
    private const endpoint = "http://api.mediastack.com/v1/news";

    //singlton
    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (is_null(NewsApi::$instance)) {
            NewsApi::$instance = new NewsApi();
        }

        return NewsApi::$instance;
    }

    function getNews(String $countryCode)
    {
        $res = Http::withOptions(['verify' => false])
            ->get($this::endpoint, [
                'access_key' => $this::apiKey,
                'countries' => $countryCode,
                'limit' => $this::responseLimit,
                'sort' => "published_desc"
            ]);

        $res = json_decode($res->getBody()->getContents());
        return ($res->data); // ->data[0]->title, data[0]->description
    }
}
