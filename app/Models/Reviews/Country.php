<?php

namespace App\Models\Reviews;

use Jenssegers\Mongodb\Eloquent\Model;

// Country reivews Model
use App\Models\Reviews\Country_Review;

class Country extends Model
{
    // use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'country';
    protected $primarykey = '_id';
    protected $fillable = ['country_code'];

    public static function getCountryReviews(String $countryCode)
    {
        $countryReviews = Country::where('country_code', $countryCode)->first();

        if (is_null($countryReviews)) {
            return null;
        }

        return $countryReviews->country_review;
    }

    public static function addCountryReviews(String $countryCode, String $userName, String $review_body)
    {
        $counrty = Country::where('country_code', $countryCode)->get();

        if (sizeof($counrty) <= 0) {
            $counrty = Country::create(['country_code' => $countryCode]);
        } else {
            $counrty = $counrty[0];
        }

        $counrty->country_review()->create(['user_name' => $userName, 'review_body' => $review_body]);

        return $counrty;
    }

    public function country_review()
    {
        return $this->hasMany(Country_Review::class);
    }
}
