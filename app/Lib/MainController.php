<?php

namespace App\Lib;

use App\Http\Controllers\Controller;

abstract class MainController extends Controller
{
    abstract function index();
    abstract function getByName();
    abstract function getByCritirea();
}
