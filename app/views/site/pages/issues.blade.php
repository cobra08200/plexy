{{-- @extends('admin.layouts.default') --}}

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">
		{{ $issue->content }}
		</h1>
		<img src="{{ $issue->poster_url }}">
	</div>

@stop