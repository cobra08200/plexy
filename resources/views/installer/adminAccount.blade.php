@extends('installer.layouts.master')

@section('container')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-file"></i>
                {{ trans('messages.account.title') }}
            </h3>
        </div>
        <div class="panel-body">
            <p>
                {{ trans('messages.account.explain') }}
            </p>
            @if ($message = Session::get('danger'))
            <header class="header-danger">
                @if (is_array($message))
            	    @foreach ($message as $m)
            	    	{{ $m }}
            	    @endforeach
                @else
                	{{ $message }}
                @endif
            </header>
            @endif
            @if (session('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <form method="post" action="{{ route('LaravelInstaller::admin.account.save') }}">
                <div class="form-group">
                    <label for="name">Plex Username or Email:</label>
                    <input type="text" class="form-control" name="plex_username_or_email" id="plex_username_or_email" value="{{ old('plex_username_or_email') }}" placeholder="Username or Email">
                </div>
                <div class="form-group">
                    <label for="Password">Plex Password</label>
                    <input type="password" class="form-control" name="plex_password" placeholder="Password">
                </div>
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-info" style="float: right;" value="{{ trans('messages.account.save') }}">
            </form>
        </div>
    </div>
@stop
