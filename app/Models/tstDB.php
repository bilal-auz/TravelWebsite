<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class tstDB extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'BILAL_TST_DB'; //name of the collection
    protected $primaykey = 'id';
    protected $fillable = ['id', 'title'];
}
