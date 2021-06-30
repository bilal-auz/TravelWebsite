<?php

namespace App\Lib;

interface ISearch
{
    //this calls the APIs
    function search();

    //this returns the searchObj values
    function getAttributes();
}
