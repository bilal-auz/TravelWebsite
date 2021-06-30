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

        return view('city.byName.results')->with('city', $city);
    }

    public function getByCriteria(Request $request)
    {
        // dd($request->cityName);
        // $city_airport_code = City::getCityAirportCode($request->input('city_name'));
        $city_airport_code = City::getCityAirportCode($request->cityName); //temp

        $city = City::searchByCriteria(new CityCriteriaSearch(
            $request->cityName,
            $city_airport_code,
            $request->hotel_min_price,
            $request->hotel_max_price,
            $request->restaurant_min_price,
            $request->restaurants_max_price,
            $request->place_keyword,
            $request->flight_min_price,
            $request->flight_max_price
            // $request->input('city_name'),
            // $city_airport_code,
            // $request->input('hotel_min_price'),
            // $request->input('hotel_max_price'),
            // $request->input('restaurant_min_price'),
            // $request->input('restaurants_max_price'),
            // $request->input('place_keyword'),
            // $request->input('flight_min_price'),
            // $request->input('flight_max_price')
        ));

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
