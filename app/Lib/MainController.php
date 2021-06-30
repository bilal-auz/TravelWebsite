<?php

namespace App\Lib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class MainController extends Controller
{
    abstract function index();
    abstract function getByName(Request $request);
    abstract function getByCriteria(Request $request);
}
