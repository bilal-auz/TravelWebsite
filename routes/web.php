<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

//models
use App\Models\tstDB;
use App\Models\tstDbSql;
use App\Models\Country;
use App\Models\City;
use App\Models\Reviews\City as CityReviews;
use App\Models\Reviews\Country as CountryReviews;

//searches
use App\Searches\CityCriteriaSearch;
use App\Searches\CityNameSearch;
use App\Searches\CountryNameSearch;
use App\Searches\CountryCriteriaSearch;

//testing
use App\APIs\FlightApi;
use App\APIs\CurrencyApi;
use App\APIs\HotelsApi;
use App\APIs\RestaurantsApi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nosql', function (Request $req) {
    error_log("zbi");
    tstDB::create(['id' => 1, 'title' => 'zbi kbir']);
    dd($req);
});

Route::get('/sql', function (Request $req) {
    tstDbSql::create([]);
});

Route::get('/date', function (Request $req) {
    return (Carbon::now()->format('Y-m-d'));
});


Route::get('/flights', function (Request $req) {
    $flight = FlightApi::getInstance();

    $flight->getFlightsWithPrice("LAX", 9500, 10000);
});

Route::get('/currency', function (Request $req) {
    $currency = CurrencyApi::getInstance();

    $currency->convert("AFN");
});

Route::get('/restaurants', function (Request $req) {
    $hotels = RestaurantsApi::getInstance();
    $hotels->getRestaurantsWithPrices("Rabat", 0, 100);
});


Route::get('/testDBmongodb/{country_code}', function ($country_code) {
    // $res = Country::create(['country_code' => $country_code, 'reviews' => array()]);
    // dd($res);
    // $newCountry = Country::where('country_code', "ZBI")->get();

    $newReview = CityReviews::addCityReview($country_code, "Bilal", "jouj");
    // dd($newReview);
    // echo $newReview->country_review;
    return view('tst2')->with('newReview', $newReview);
});


#SEARCH BY NAME(Country and City)
Route::get('/searchByName/Country{countryName}', function ($countryName) {
    // $country = Country::where('country_name', $countryName)->get();
    // dd($country[0]);

    $country = Country::getCountryInfo($countryName);

    $res = Country::searchByName($country->country_name, new CountryNameSearch($country->country_name, $country->alpha_2_code, $country->currency_code));
    return view('countryTest')->with('res', $res);
});

Route::get('/searchByName/City/{cityName}', function ($cityName) {
    $cityAirportCode = City::getCityAirportCode($cityName);

    $city = City::searchByName(new CityNameSearch($cityName, $cityAirportCode));
    dd($city);
});


#SEARCH BY Criteria(Country and city)
route::get('/searchByCriteria/Country', function (Request $request) {
    $res =  Country::searchByCriteria(new CountryCriteriaSearch($request->language, $request->currency, $request->continent));
    dd($res);
});
route::get('/searchByCriteria/Country', function (Request $request) {
    $res =  City::searchByCriteria(new CityCriteriaSearch(
        $request->cityName,
        $request->CityCriteriaSearch,
        $request->hotelMinPrice,
        $request->hotelMinPrice,
        $request->hotelMaxPrice,
        $request->restaurantMinPrice,
        $request->restaurantMixPrice,
        $request->placeKeyWord,
        $request->flightMinPrice,
        $request->flightMaxPrice,
        $request->hotelMinPrice
    ));
    dd($res);
});



// Route::get('/tstHotels', function (Request $req) {
//     error_log("inside");
//     $tst = new CityCriteriaSearch();
//     $tst->setDestinationAirportCode("ZBI");
//     $tst->setHotelMinPrice(11);
//     $tst->setHotelMaxPrice(55);
//     dd($tst->search());
// });
