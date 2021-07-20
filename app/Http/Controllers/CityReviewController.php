<?php

namespace App\Http\Controllers;

use App\Models\Reviews\City;
use Illuminate\Http\Request;

class CityReviewController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input('city_name'));
        City::addCityReview($request->input('city_name'), $request->input('user_name'), $request->input('review_body'));
        return redirect()->back();
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Reviews\City  $city
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Request $request)
    {
        return City::getCityReviews($request->city_name);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reviews\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviews\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
