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
            @if (session('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <form method="post" action="{{ route('LaravelInstaller::admin.account.save') }}">
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="Email">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                {!! csrf_field() !!}
                <input type="submit" class="btn btn-info" style="float: right;" value="{{ trans('messages.account.save') }}">
            </form>
        </div>
    </div>
@stop
