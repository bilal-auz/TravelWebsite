@extends('layout.app')
@section('body')
    <div class="main searchForm">
        <div class="header">
            <div class="mainTitle">
                <h1 id='title'><a href="/home">Travel</a></h1>
            </div>
            <div class="subTitle">
                <h2>Search For Country</h2>
            </div>
        </div>
        <div class="formSection">
            <div class="formContainer">
                <form action="{{ route('country.nameSearch') }}" method="GET">
                    <div>
                        <label for="countryName">Country Name</label>
                        <input type="text" name="countryName" id="">
                    </div>
                    <div class="formButton">
                        <button onclick="loading();">search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection