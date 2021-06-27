<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\tstDB;
use App\Models\tstDbSql;
use App\Searches\CityCriteriaSearch;
use Carbon\Carbon;

//testing
use App\APIs\FlightApi;
use App\APIs\CurrencyApi;

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

    $flight->getFlights("LAX");
});

Route::get('/currency', function (Request $req) {
    $currency = CurrencyApi::getInstance();

    $currency->convert("AFN");
});

// Route::get('/tstHotels', function (Request $req) {
//     error_log("inside");
//     $tst = new CityCriteriaSearch();
//     $tst->setDestinationAirportCode("ZBI");
//     $tst->setHotelMinPrice(11);
//     $tst->setHotelMaxPrice(55);
//     dd($tst->search());
// });
