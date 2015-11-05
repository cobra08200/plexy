@if(Request::path() != '/')
<a href="{{ route('home') }}">Home</a>
@endif

@if (Auth::check())
<a href="{{ route('logout') }}">Logout</a>
@else
<a href="{{ route('login') }}">Login</a>
@endif

{{-- <a target="_blank" href="https://cash.me/$ehumps">Donate</a> --}}

<hr>
