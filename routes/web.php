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
use App\APIs\ImagesApi;
use App\APIs\MapQuestApi;
use App\APIs\PlaceToDiscover;
use App\APIs\RestaurantsApi;
use App\APIs\RestaurantsHereApi;
use App\APIs\WeatherApi;
use App\Http\Controllers\CityController;
//controllers
use App\Http\Controllers\CountryReviewController;
use App\Http\Controllers\CityReviewController;
use App\Http\Controllers\CountryController;

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

Route::get('/hotels', function (Request $req) {
    $hotels = HotelsApi::getInstance();

    $codes = City::getCityInfo('khartoum');

    $coord = City::getCityCoords('khartoum');
    dd($coord);
    $res = $hotels->getHotels($codes[0], $coord->lat, $coord->lng);
    dd($res);
});
Route::get('/flights', function (Request $req) {
    $flight = FlightApi::getInstance();
    // $weather = WeatherApi::getInstance();

    // $city = "new York";

    // $codes = City::getCityInfo($city);

    // $coord = $weather->getCityCoord($city);

    $res = $flight->getFlightsWithPrices("LGA", '10000', '99999');

    dd($res);
});

Route::get('/currency', function (Request $req) {


    $currency = CurrencyApi::getInstance();

    $currency->convert("AFN");
});

Route::get('/restaurants', function (Request $req) {
    $hotels = RestaurantsHereApi::getInstance();
    $weather = WeatherApi::getInstance();
    $coord = $weather->getCityCoord('doha');
    dd($coord);
    $res = $hotels->getRestaurants($coord);
    dd($res);
});

Route::get('/weather', function (Request $req) {
    $weather = WeatherApi::getInstance();
    $res = $weather->getWeather("doha");
    // $res = explode(".", $res->main->temp, 99)[0];
    dd($res);
});

Route::get('/res', function (Request $req) {
    $resto = RestaurantsHereApi::getInstance();
    $weather = WeatherApi::getInstance();

    $coord = $weather->getCityCoord('rabat');
    dd($coord);
    $r = $resto->getRestaurants($coord);
    echo 'in';
    dd($r);
});

Route::get('/place', function (Request $req) {
    $place = PlaceToDiscover::getInstance();
    $res = $place->getRandPlace("casaBlAnca");
    dd($res);
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

Route::get('/image', function () {
    $imageApi = ImagesApi::getInstance();

    $res = $imageApi->getImage("khartoum");

    $link = $res->results[random_int(0, 10)]->urls->regular;
    return view('tst')->with('link', $link);
});

/*

#SEARCH BY NAME(Country and City)
Route::get('/searchByName/Country/{countryName}', function ($countryName) {
    // $country = Country::where('country_name', $countryName)->get();
    // dd($country[0]);

    $country = Country::getCountryInfo($countryName);
    dd($country);
    $res = Country::searchByName($country->country_name, new CountryNameSearch($country->country_name, $country->alpha_2_code, $country->currency_code));
    return view('countryTest')->with('res', $res);
});

Route::get('/searchByName/City/{cityName}', function ($cityName) {
    $cityAirportCode = City::getCityAirportCode($cityName);

    $city = City::searchByName($cityName);
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

*/

Route::get('/home', function () {
    return view('index');
});

route::prefix('countryReviews')->group(function () {
    Route::get('/', [CountryReviewController::class, 'show']);
    Route::post('/', [CountryReviewController::class, 'store'])->name('countryReviews.store');
});
route::prefix('cityReviews')->group(function () {
    // dd("inside");
    Route::get('/', [CityReviewController::class, 'show']);
    Route::post('/', [CityReviewController::class, 'store'])->name('cityReviews.store');
});

Route::get('/searchByName', function () {
    return view('cityOrCountry');
});
Route::get('/searchByCriteria', function () {
    return view('cityOrCountry');
});


Route::prefix('/searchByName')->group(function () {
    //enter country name form view
    Route::get('/Country', function () {
        return view('country.byName.searchForm');
    });

    //show result
    Route::get('/Country/search', [CountryController::class, 'getByName'])->name('country.nameSearch');

    //enter city name (form view)
    Route::get('/City', function () {
        return view('city.byName.searchForm');
    });

    //show result
    Route::get('/City/search', [CityController::class, 'getByName'])->name('city.nameSearch');
});

Route::prefix('/searchByCriteria')->group(function () {
    //enter country name form view
    Route::get('/Country', function () {
        return view('country.byCriteria.searchForm');
    });
    Route::get('/Country/search', [CountryController::class, 'getByCriteria'])->name('country.criteriaSearch');

    //enter city name form view
    Route::get('/City', function () {
        return view('city.byCriteria.searchForm');
    });
    Route::get('/City/search', [CityController::class, 'getByCriteria'])->name('city.criteriaSearch');
});

// Route::get('/tstHotels', function (Request $req) {
//     error_log("inside");
//     $tst = new CityCriteriaSearch();
//     $tst->setDestinationAirportCode("ZBI");
//     $tst->setHotelMinPrice(11);
//     $tst->setHotelMaxPrice(55);
//     dd($tst->search());
// });

Route::get('/resultTst', function () {

    $city = file_get_contents('C:\Users\belal\Desktop\Internship_Project\5-Development\Travel-Website-v8\public\ApiResponses\city');

    $city = json_decode($city);

    return view('resultTst')->with('city', $city);
});

Route::get('/cities', function () {
    City::getCitiesInCountry('United states');
});


Route::get('/coords', function () {
    $coords = MapQuestApi::getInstance();
    $coords->getPlaceCoords("rabat");
});
