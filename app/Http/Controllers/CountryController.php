<?php

namespace App\Http\Controllers;

use App\Lib\MainController;

use App\Models\Country;
use Illuminate\Http\Request;

//Searches
use App\Searches\CountryNameSearch;
use App\Searches\CountryCriteriaSearch;
use Illuminate\Support\Facades\Storage;

class CountryController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function getByName(Request $request)
    {
        // dd($request->countryName);
        // $country = Country::searchByName($request->input('country_name'));

        $country = Country::searchByName($request->countryName);

        // $file = fopen('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\country', 'w');

        // fwrite($file, json_encode($country));
        // fclose($file);
        // dd($country);


        // $country = file_get_contents('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\country');


        // return view('country.byName.resutls')->with('country', json_decode($country, true));

        return view('country.byName.resutls')->with('country', $country);
    }

    public function getByCriteria(Request $request)
    {
        // dd($request->language);
        $countries = Country::searchByCriteria(new CountryCriteriaSearch(
            $request->language,
            $request->currency,
            $request->continent
        ));

        return view('country.byCriteria.results')->with('countries', $countries);
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
