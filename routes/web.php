<?php

use Illuminate\Support\Facades\Route;

//controllers
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryReviewController;
use App\Http\Controllers\CityReviewController;

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
