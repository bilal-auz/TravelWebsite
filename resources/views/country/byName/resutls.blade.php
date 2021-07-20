@extends('layout.app')
@section('body')
{{-- {{ dd($country) }} --}}
    <div class="main results">
        <div class="header">
            <div class="mainTitle">
                <h1 id='title'><a href="/home">Travel</a></h1>
            </div>
            <div class="subTitle">
                <h2>{{ $country['name'] }}</h2>
            </div>
        </div>
        <div class="resultBody">
            <div class="blured countryCards">
                <h3>Inforamtion</h3>
                <div class="info">
                    <div class="info1">
                        <div class="block">
                            <p class="fix">Capital:</p>
                            <p class="var">{{ $country['capital'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">language:</p>
                            <p class="var">{{ $country['language'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">currency Name:</p>
                            <p class="var">{{ $country['currencyName'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">currency Code:</p>
                            <p class="var">{{ $country['currencyCode'] }}</p>
                        </div>
                    </div>
                    <div class="info2">
                        <div class="block">
                            <p class="fix">regional organization:</p>
                            <p class="var">{{ $country['regionalOrg'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">timeZone:</p>
                            <p class="var">{{ $country['timeZone'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">ISO:</p>
                            <p class="var">{{ $country['alphaCode'] }}</p>
                        </div>
                        <div class="block">
                            <p class="fix">CURRENCY RATE:</p>
                            <p class="var">{{ $country['currencyConvert']['query']->amount }} {{ $country['currencyConvert']['query']->from }} = {{ $country['currencyConvert']['result'] }} {{ $country['currencyConvert']['query']->to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="blured countryCards">
                <h3>News</h3>
                <div class="news">
                    @if (!array_key_exists("error", $country['news']))
                        @if ($country['news']->pagination->count > 0)
                            @foreach ($country['news']->data as $new )
                                <div class="news-wrap">
                                    <div class="news-wrap_Center">
                                        <div class="new">
                                            <p class="new-title">{!! $new->title !!}</p>
                                            <P class="new-body">{!!  $new->description  !!}</P>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="news-wrap error">
                                <p class="error_message">NOT FOUND</p>
                            </div>
                        @endif
                    @else
                        <div class="news-wrap error">
                            <p class="error_message">NOT AVAILABLE</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="blured countryCards">
                <h3>Cities</h3>
                <div class="cities">
                    @if (!is_null($country['cities']))
                        @foreach ($country['cities'] as $city )
                            <div class="city-wrap">
                                <div class="city-wrap_Center">
                                    <div class="city">
                                        <a href="/searchByName/City/search?cityName={{ $city['city_name'] }}">{{ $city['city_name'] }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="city-wrap error">
                            <p class="error_message">Not Available</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="blured countryCards">
                <h3>Map</h3>
                <div class="map">
                    <div class="mapWrap">
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBkGhMAi6HabREfRtRCA59J6-exLwgNXiE
                        &q={{ $country['name'] }}" frameborder="0">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="cols col3">
                <div>
                    <div class="wrap">
                        <div class="container reviews">
                            <div class="reviews">
                                <!-- comments container -->
                                <div class="comment_block">
                                    <!-- used by #{user} to create a new comment -->
                                    <div class="create_new_comment">
                                        <form action="{{ route('countryReviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="country_code" value="{{ $country['alphaCode'] }}">
                                            <div class="user_avatar">
                                                <input type="text" name="user_name" placeholder="Your Name..">
                                            </div>
                                            <div class="input_comment">
                                                <textarea type="text" name="review_body" placeholder="Write Your Review.."></textarea>
                                                <button type="submit">SEND</button>
                                            </div>
                                        </form>
                                    </div>

                                    @if (!is_null($country['reviews']))
                                        @foreach ($country['reviews'] as $review )
                                            <div class="new_comment">
                                                <!-- build comment -->
                                                <ul class="user_comment">
                                                    <!-- current #{user} avatar -->
                                                    <div class="user_avatar">
                                                        <p>{{ $review->user_name }}</p>
                                                    </div>
                                                    <!-- the comment body -->
                                                    <div class="comment_body">
                                                        <p>{{ $review->review_body }}</p>
                                                    </div>
                                                    <!-- comments toolbar -->
                                                    <div class="comment_toolbar">
                                                        <!-- inc. date and time -->
                                                        <div class="comment_details">
                                                            <ul>
                                                            <li><i class="fa fa-clock-o"></i> {{ $review["created_at"]->toDateTime()->format("H:i") }}</li>
                                                            <li><i class="fa fa-calendar"></i> {{ $review["created_at"]->toDateTime()->format("d/m/Y") }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="itemWrap error">
                                            <p class="error_message">No reviews yet</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection