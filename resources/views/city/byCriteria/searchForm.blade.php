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
                <form action="{{ route('city.criteriaSearch') }}" method="GET">
                    <div>
                        <label for="cityName">City Name</label>
                        <input type="text" name="cityName" id="">
                    </div>
                    <div class="smallInput">
                        <label for="hotel_min_price">Hotel Price</label>
                        <div>
                            <input type="text" name="hotel_min_price" id="" placeholder="min">
                            <input type="text" name="hotel_max_price" id="" placeholder="max">
                        </div>
                    </div>
                    <div class="smallInput">
                        <label for="restaurant_min_price">Restaurant Price</label>
                        <div>
                            <input   style="background-color: grey; border-radius:5px" disabled type="text" name="restaurant_min_price" id="" placeholder="min">
                            <input   style="background-color: grey; border-radius:5px" disabled type="text" name="restaurants_max_price" id="" placeholder="max">
                        </div>
                    </div>
                    <div class="smallInput">
                        <label for="flight_min_price">Flight Price</label>
                        <div>
                            <input type="text" name="flight_min_price" id="" placeholder="min">
                            <input type="text" name="flight_max_price" id="" placeholder="max">
                        </div>
                    </div>
                    <div>
                        <label for="place_keyword">Place keyword</label>
                        <input type="text" name="place_keyword" id="">
                    </div>
                    <div class="formButton">
                        <button onclick="loading();">search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection