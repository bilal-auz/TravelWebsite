<?php

namespace App\Models\Reviews;

use Jenssegers\Mongodb\Eloquent\Model;

class Country_Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'country_reviews';
    protected $primaryKey = '_id';
    protected $fillable = ['user_name', 'review_body'];

    public function addNewReview(String $userName, String $review_body)
    {
        Country_Review::create(['user_name' => $userName, 'review_body' => $review_body]);
    }
}
