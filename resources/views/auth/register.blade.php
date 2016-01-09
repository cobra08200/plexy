@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form class="ui form" method="post" action="{{ route('register.post') }}">
  {!! csrf_field() !!}
  <div class="field">
    <label>Plex Username or Plex Email Address</label>
    <input type="email" name="plex_username_or_email" id="plex_username_or_email" value="{{ old('plex_username_or_email') }}" autocorrect="off" autocapitalize="none">
  </div>
  <div class="field">
    <label>Plex Password</label>
    <input type="password" name="plex_password" id="password" class="form-control">
  </div>
  <button class="ui button" type="submit" id="submit_button">Submit</button>
</form>

@stop
