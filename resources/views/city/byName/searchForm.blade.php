@extends('layout.app')
@section('body')
    <div class="main searchForm">
        <div class="header">
            <div class="mainTitle">
                <h1 id='title'><a href="/home">Travel</a></h1>
            </div>
            <div class="subTitle">
                <h2>Search For City</h2>
            </div>
        </div>
        <div class="formSection">
            <div class="formContainer">
                <form action="{{ route('city.nameSearch') }}" method="GET">
                    <div>
                        <label for="cityName">City Name</label>
                        <input type="text" name="cityName" id="">
                    </div>
                    <div class="formButton">

                        <button onclick="loading();">search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection