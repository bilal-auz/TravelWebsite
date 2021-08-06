<?php

namespace App\Models\Reviews;

use Jenssegers\Mongodb\Eloquent\Model;

// City Reivews Model
use App\Models\Reviews\City_Review;

class City extends Model
{
    // use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'city';
    protected $primarykey = '_id';
    protected $fillable = ['city_name'];

    public static function getCityReviews(String $city_name)
    {
        try {
            $cityReviews = City::where('city_name', $city_name)->first();
            if (is_null($cityReviews)) {
                return null;
            }
            return $cityReviews->city_review;
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public static function addCityReview(String $city_name, String $user_name, String $review_body)
    {
        try {
            $city = City::where('city_name', $city_name)->get();

            if (sizeof($city) <= 0) {
                $city = City::create(['city_name' => $city_name]);
            } else {
                $city = $city[0];
            }

            $city->city_review()->create(['user_name' => $user_name, 'review_body' => $review_body]);

            return $city;
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function city_review()
    {
        return $this->hasMany(City_Review::class);
    }
}
