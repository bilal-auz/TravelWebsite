<?php

namespace App\Http\Controllers;

use App\Lib\MainController;
use App\Models\City;
use Illuminate\Http\Request;

//Searches
use App\Searches\CityNameSearch;
use App\Searches\CityCriteriaSearch;

class CityController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getByName(Request $request)
    {
        // $city = City::searchByName($request->input('city_name'));
        $city = City::searchByName($request->cityName); //temp

        // $file = fopen('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\city', 'w');
        // // fwrite($file, json_encode($city));
        // fwrite($file, $city);
        // fclose($file);

        // file_put_contents('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\city', json_encode($city));

        // $city = file_get_contents('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\city');

        // $city = json_decode($city);

        // dd($city);

        return view('city.byName.results')->with('city', $city);
    }

    public function getByCriteria(Request $request)
    {
        // $city_airport_code = City::getCityAirportCode($request->input('city_name'));

        // $city = City::searchByCriteria($request->cityName);

        $airportCodes = City::getCityInfo($request->cityName);

        $coords = City::getCityCoords($request->cityName);


        $citySearch = new CityCriteriaSearch(
            $request->cityName,
            $airportCodes,
            $coords->lat,
            $coords->lng,
            $request->hotel_min_price,
            $request->hotel_max_price,
            $request->restaurant_min_price,
            $request->restaurants_max_price,
            $request->place_keyword,
            $request->flight_min_price,
            $request->flight_max_price
        );

        $city = City::searchByCriteria($citySearch);

        // dd($city);

        return view('city.byCriteria.results')->with('city', $city);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
