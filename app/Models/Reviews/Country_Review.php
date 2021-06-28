<?php

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Country_Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'country_reviews';
    protected $primaryKey = '_id';
    protected $fillable = ['userName', 'review_body'];

    public function addNewReview(String $userName, String $review_body)
    {
        Country_Review::create(['userName' => $userName, 'review_body' => $review_body]);
    }
}
