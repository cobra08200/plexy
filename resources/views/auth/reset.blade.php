@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form class="ui form" method="post" action="{{ route('password.reset.post') }}">
  {!! csrf_field() !!}
  <input type="hidden" name="token" value="{{ $token }}">
  <div class="field">
    <label>Email Address</label>
    <input type="email" name="email" value="{{ old('email') }}" autocorrect="off" autocapitalize="none">
  </div>
  <div class="field">
    <label>Password</label>
    <input type="password" name="password">
  </div>
  <div class="field">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation">
  </div>
  <button class="ui button" type="submit" id="submit_button">Reset Password</button>
</form>

@stop
