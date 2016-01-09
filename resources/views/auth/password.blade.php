@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form class="ui form" method="post" action="{{ route('password.email.post') }}">
  {!! csrf_field() !!}
  <div class="field">
    <label>Email Address</label>
    <input type="email" name="email" value="{{ old('email') }}" autocorrect="off" autocapitalize="none">
  </div>
  <button class="ui button" type="submit" id="submit_button">Send Password Reset Link</button>
</form>

@stop
