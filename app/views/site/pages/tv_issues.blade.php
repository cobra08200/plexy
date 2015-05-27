@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="row">
	<h2 class="page-header" align="center">
		{{ $issue->content }}
	</h2>

	<div class="col-md-4">
		<img src="{{ $issue->poster_url }}" height="200" alt="">
	</div>

	<div class="col-md-8">

		{{ Form::open(array('route' => 'tv.issue', 'class' => 'search__form', 'role' => 'search')) }}
		<div class="form-group">

		<input type="hidden" name="title" value="{{ $issue->title }}">
		<input type="hidden" name="year" value="{{ $issue->year }}">
		<input type="hidden" name="tmdb" value="{{ $issue->tmdb }}">
		<input type="hidden" name="poster" value="{{ $issue->poster_url }}">
		<input type="hidden" name="backdrop" value="{{ $issue->backdrop }}">
		<input type="hidden" name="topic" value="{{ $issue->topic }}">
		<input type="hidden" name="vote_average" value="{{ $issue->vote_average }}">

		{{ Form::text('Season', '', array('class' => 'typeahead form-control search__input','placeholder' => 'Season')) }}
		{{ Form::text('Episode', '', array('class' => 'typeahead form-control search__input','placeholder' => 'Episode')) }}

		<div class="search__actions">
		    <button type="submit" name="type" value="Issue" class="btn btn-default report button--text">Report an Issue</button>
		</div>
		{{ Form::close() }}

	</div>
</div>

@stop
