<div class="ui secondary pointing menu">
  <div class="header item">Plexy</div>
  @if (Auth::check())
  @if (Request::url() != '/')
  @endif
  <div class="right menu">
    <a class="item {{ Request::path() == '/' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
    <div class="ui dropdown item">
      Donate
      <i class="dropdown icon"></i>
      <div class="menu">
        <a class="item" target="_blank" href="https://cash.me/$ehumps">Square Cash</a>
        <a class="item" target="_blank" href="https://venmo.com/ehumps">Venmo</a>
      </div>
    </div>
  </div>
  <a class="item" href="{{ route('logout') }}">Logout</a>
  @else
  <div class="right menu">
    <a class="item {{ Request::path() == 'login' ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
    <a class="item {{ Request::path() == 'password/email' ? 'active' : '' }}" href="{{ route('password.email') }}">Forgot Password</a>
    <a class="item {{ Request::path() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
  </div>
  @endif
</div>
