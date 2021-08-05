<?php

namespace App\Http\Controllers;

use App\Lib\MainController;
use App\Models\City;
use Illuminate\Http\Request;

//Searches
use App\Searches\CityCriteriaSearch;

//support models
use App\Models\Reviews\City as CityReviews;


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
        $city = City::searchByName($request->cityName); //temp

        return view('city.byName.results')->with('city', $city);
    }

    public function getByCriteria(Request $request)
    {
        $reviews = CityReviews::getCityReviews($request->cityName);

        $airportCodes = City::getCityAirportCodes($request->cityName);

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

        $city['reviews'] = $reviews;

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
