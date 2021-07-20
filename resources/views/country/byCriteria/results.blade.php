@extends("layout.app")
@section('body')
{{-- {{ dd($countries[2]->cities()) }} --}}
<div class="main results countries">
    <div class="header countries">
        <div class="mainTitle">
            <h1 id='title'><a href="/home">Travel</a></h1>
        </div>
        <div class="subTitle">
            <h2>Found: {{ count($countries) }}</h2>
        </div>
    </div>
    <div class="resultBody criteria">
        <div class="criteriaResult">
            <div class="criteriaResult_List">
                @foreach ($countries as $country )
                    <div class="countryWrap">
                        <p class="country"><a href="/searchByName/Country/search?countryName={{ $country->country_name }}">{{ $country->country_name }}</a></p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection