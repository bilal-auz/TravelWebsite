<?php

namespace App\Models\Reviews;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class City_Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'city_reviews';
    protected $primaryKey = '_id';
    protected $fillable = ['user_name', 'review_body'];

    public function addNewReview(String $userName, String $review_body)
    {
        City_Review::create(['user_name' => $userName, 'review_body' => $review_body]);
    }
}
