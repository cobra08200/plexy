@if (Auth::check())
You are: {{ Auth::user()->name }} -
@if(Request::path() != '/')
<a href="{{ route('home') }}">Home</a>
@endif
<a href="{{ route('logout') }}">Logout</a>
@else
<a href="{{ route('login') }}">Login</a>
<a href="{{ route('register') }}">Register</a>
@endif

{{-- <a target="_blank" href="https://cash.me/$ehumps">Donate</a> --}}

<hr>
