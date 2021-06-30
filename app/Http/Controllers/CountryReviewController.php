<?php

namespace App\Http\Controllers;

use App\Models\Reviews\Country;
use Illuminate\Http\Request;

class CountryReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "s";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return;
        //save a review
        Country::addCountryReviews($request->input('country_code'), $request->input('user_name'), $request->input('review_body'));
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Reviews\Country  $country
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Request $request)
    {
        // dd($request->);
        //get reviews pass the countryCode as url param
        return Country::getCountryReviews($request->country_code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reviews\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviews\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
