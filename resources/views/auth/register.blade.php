@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form method="POST" action="{{ route('register.post') }}">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="name">Plex Username or Email:</label>
        <input type="text" name="plex_username_or_email" id="name" class="form-control" value="{{ old('plex_username_or_email') }}">
    </div>

    <div class="form-group">
        <label for="password">Plex Password:</label>
        <input type="password" name="plex_password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default">Register</button>
    </div>
</form>

@stop
