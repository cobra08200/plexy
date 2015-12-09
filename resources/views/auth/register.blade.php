@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form class="ui form" method="post" action="{{ route('register.post') }}">
  {!! csrf_field() !!}
  <div class="field">
    <label>Username or Email Address</label>
    <input type="text" name="plex_username_or_email" id="plex_username_or_email" value="{{ old('plex_username_or_email') }}">
  </div>
  <div class="field">
    <label>Password</label>
    <input type="password" name="plex_password" id="password" class="form-control">
  </div>
  <button class="ui button" type="submit" id="submit_button">Submit</button>
</form>

@stop
