@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="login__card">
	<h1 class="login__logo">Plexy Logo</h1>
	{{ Confide::makeLoginForm()->render() }}
</div>

@stop
