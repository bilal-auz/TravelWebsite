@include('layout.head')
<div class="loadDiv">
    <span class="loader">
    </span>
</div>
<div id="section-landing">
    @yield('body')
    @include('layout.footer')
</div>