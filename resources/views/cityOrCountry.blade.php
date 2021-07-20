@extends('layout.app')

@section('body')
<div class="main choices">
    <div class="homeTitle">
        <h1 id='title'><a href="/home">Travel</a></h1>
    </div>
    <div class="homeBody choice">
        <div class="choice_btns">
            <span id="slash"></span>
            <a href="{{ url()->current() }}/Country">Country</a>
            <a href="{{ url()->current() }}/City">City</a>
        </div>
    </div>
</div>
@endsection