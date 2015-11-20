@extends('installer.layouts.master')

@section('container')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-file"></i>
                {{ trans('messages.environment.title') }}
            </h3>
        </div>
        <div class="panel-body">
            @if (session('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <form method="post" action="{{ route('LaravelInstaller::environmentSave') }}">
                <div class="bs-component">
                    <ul class="list-group">
                        <textarea name="envConfig" rows="33" cols="68">{{ $envConfig }}</textarea>
                    </ul>
                </div>
                @if (!isset($environment['errors']))
                    @if (env('TMDB_TOKEN') == null || env('PLEX_SERVER_URL') == null)
                        <ul>
                            @if (env('TMDB_TOKEN') == null)
                                <li>The Movie DB Token is required.</li>
                            @endif

                            @if (env('PLEX_SERVER_URL') == null)
                                <li>Plex Server URL is required.</li>
                            @endif
                        </ul>
                    @else
                        <a class="btn btn-success" href="{{ route('LaravelInstaller::requirements') }}">
                            {{ trans('messages.next') }}
                        </a>
                    @endif
                @endif
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-info" style="float: right;" value="{{ trans('messages.environment.save') }}">
            </form>
        </div>
    </div>
@stop
