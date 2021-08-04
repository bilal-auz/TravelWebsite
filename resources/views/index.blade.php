@extends('layout.app')

@section('body')
<div class="homePage">
    <div class="homeTitle">
        <h1 id='title'><a href="/home">Travel</a></h1>
    </div>
    <div class='homeBody'>
        <div class="homeBody-midBox">
            <h2 id='upperSentence'>know more about</h2>
            <span class="arrow right">
                <img id='rightArrow' src="{{ asset('images/arrows.svg') }}" alt="arrow"/>
            </span>
            <span class="arrow left">
                <img id='leftArrow' src="{{ asset('images/arrows.svg') }}" alt="arrow"/>
            </span>
            <h2 id="bottomSentence">Your Next Destination</h2>
        </div>
    </div>
    <div class="searchSymbol" onclick="document.getElementsByClassName('searchSection')[0].scrollIntoView({behavior: 'smooth'})">
        <p id="searchBtn"> 
            <img src="{{ asset('images/searchSymbol.svg') }}" alt="search"/>
        </p>
    </div>
</div>
<div class="searchSection">
    <div class="searchSection_title">
        <h2>Search By...</h2>
    </div>
    <div class="searchSection_body">
        <div class="container">
            <div class="searchBox">
                <a href="/searchByName">Name</a>
                <span id="borderLine"></span>
                <a href="/searchByCriteria">Criteria</a>
            </div>
        </div>
    </div>
</div>
@endsection