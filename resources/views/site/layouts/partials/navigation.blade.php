<div class="ui secondary pointing menu">
  <div class="header item">Plexy</div>
  @if (Auth::check())
  @if (Request::url() != '/')
  @endif
  <div class="right menu">
    <a class="item {{ Request::path() == '/' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
    <a class="item" href="{{ route('logout') }}">Logout</a>
    <a class="item" target="_blank" href="https://cash.me/$ehumps">Donate</a>
  </div>
  @else
  <div class="right menu">
    <a class="item {{ Request::path() == 'login' ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
    <a class="item {{ Request::path() == 'password/email' ? 'active' : '' }}" href="{{ route('password.email') }}">Forgot Password</a>
    <a class="item {{ Request::path() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
  </div>
  @endif
</div>
