@extends('layout.app')
@section('body')
{{-- {{ dd($city) }} --}}
<script src="{{ asset('/js/headerScroll.js') }}"></script>
<script>
    $(".resultHead").style.background = url($city['image']->results[$city['image']->randomIndex]->urls->full );
</script>
    <div class="main">
        <div class="transparens">
            <div class="header resultHead" style="background-image: url({{ $city['image']->results[$city['image']->randomIndex]->urls->full }})">
                <div id="blackFilter">
                    <div class="mainTitle">
                        <h1 id='title'><a href="/home">Travel</a></h1>
                    </div>
                    <div class="subTitle">
                        <h2>{{ $city['name'] }} <span id="weather">{{ $city['weather']->main->temp }}<span>°C</span></span></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="resultBody">
            <div class="cityResult">
                <div class="cols col1">
                    <div class="col1_1">
                        <div class="blured" style="background-image: url({{ asset('/images/pattern1.svg') }});">
                            <div class="slider hotels">
                                <h3>Hotels</h3>
                                @if (!array_key_exists("errors", $city['hotels']))
                                    @if (count($city['hotels']->data) > 0)
                                        @foreach ($city['hotels']->data as $hotel)
                                        <div class="itemWrap">
                                            <div class="itemWrap_center">
                                                <div class="item">
                                                    {{-- <p>{{ $hotel['hotel']['name'] }}
                                                    </p> --}}
                                                    <p class="name">{{ $hotel->hotel->name }}
                                                    </p>
                                                    {{-- <p>{{ $hotel['offers'][0]['price']['total'] }}
                                                    </p> --}}
                                                    <p class="price">Price: {{ $hotel->offers[0]->price->total }} <span>{{ $hotel->offers[0]->price->currency }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="itemWrap error">
                                            <p class="error_message">NOT AVAILABLE</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="itemWrap error">
                                        <p class="error_message">{{ $city['hotels']->errors[0]->title }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col1_2">
                        <div class="blured" style="background-image: url({{ asset('/images/pattrenPlane.svg') }});">
                            <div class="slider restaurants">
                                <h3>Restaurants</h3>
                                @foreach ($city['restaurants']->results->items as $restaurant)
                                <div class="itemWrap">
                                    <div class="itemWrap_center">
                                        <div class="item">
                                            <p class="name">{{ $restaurant->title }} </p>
                                            <p class="price">No Price Yet</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cols col2">
                    <div class="col2_1">
                        <div class="container">
                            <div class="p1">
                              <div class="p1-img"><img src="{{ $city['image']->results[$city['image']->randomIndex]->urls->thumb }}" alt=""></div>
                              <div class="p1-name"><p>{{ $city['image']->results[$city['image']->randomIndex]->description }}</p></div>
                            </div>
                            <div class="p2"><p>{{ $city['image']->results[$city['image']->randomIndex]->alt_description }}</p>
                            </div>
                          </div>
                    </div>
                    <div class="col2_2">
                        <div class="wrap">
                            <div class="container">
                                <div class="flight">
                                    <div class="icon">
                                        <div class="iconWrap">
                                            <img src="{{ asset('images/plane.svg') }}" alt="">
                                        </div>
                                    </div>
                                    @if (count($city['flights']) > 0)
                                        <div class="data">
                                            <div class="dataInfo">
                                                <div class=" dataCol col1">
                                                    <div>
                                                        <p class="fix">from:</p>
                                                        <p class="var">{{ $city['flights'][0]->itineraries[0]->segments[0]->departure->iataCode }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fix">class:</p>
                                                        <p class="var">{{ $city['flights'][0]->travelerPricings[0]->fareDetailsBySegment[0]->cabin }}</p>
                                                    </div>
                                                </div>
                                                <div class="dataCol col2">
                                                    <div>
                                                        <p class="fix">to:</p>
                                                        <p class="var">{{ $city['airportCode'][0] }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="fix">date:</p>
                                                        <p class="var">{{ $city['flights'][0]->lastTicketingDate }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dataPrice">
                                                <div>
                                                    <p class="fix">price:</p>
                                                    <p class="var">{{ $city['flights'][0]->price->total }} {{ $city['flights'][0]->price->currency }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <p>NOT AVAILABLE</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
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
                                            <form action="{{ route('cityReviews.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="city_name" value="{{ $city['name'] }}">
                                                <div class="user_avatar">
                                                    <input type="text" name="user_name" placeholder="Your Name..">
                                                </div>
                                                <div class="input_comment">
                                                    <textarea type="text" name="review_body" placeholder="Write Your Review.."></textarea>
                                                    <button type="submit">SEND</button>
                                                </div>
                                            </form>
                                        </div>

                                        @if (!is_null($city['reviews']))
                                            @foreach ($city['reviews'] as $review )
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
                {{-- <p>hotels</p>
                @foreach ($city['hotels']['data'] as $hotel)
                    <p>{{ $hotel['hotel']['name'] }}</p>
                    <p>{{ $hotel['offers'][0]['price']['total'] }}</p>
                @endforeach --}}
            </div>
        </div>
    </div>
    {{-- {{ dd($city) }} --}}
@endsection