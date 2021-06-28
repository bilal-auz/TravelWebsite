<?php

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class City extends Model
{
    // use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'city';
    protected $primarykey = '_id';
    protected $fillable = ['city_name'];

    public static function getCityReviews(String $cityName)
    {
        $cityReviews = City::where('country_code', $cityName)->first();
        return $cityReviews;
    }

    public static function addCityReview(String $cityName, String $userName, String $review_body)
    {
        $city = City::where('city_name', $cityName)->get();

        if (sizeof($city) <= 0) {
            $city = City::create(['city_name' => $cityName]);
        } else {
            $city = $city[0];
        }

        $city->city_review()->create(['userName' => $userName, 'review_body' => $review_body]);

        return $city;
    }

    public function city_review()
    {
        return $this->hasMany(City_Review::class);
    }
}
