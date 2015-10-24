@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="cd-fold-content single-page">
	<p>{{ $issue->content }}</p>
	<img src="{{ $issue->poster_url }}" width="200px" alt="{{ $issue->content }}">

	<form class="" action="{{ route('search.submit') }}" method="post">
	{!! csrf_field() !!}

	<div class="section group">
		<div class="col span_1_of_2">
			What's up?
		</div>
		<div class="col span_1_of_2">
			<select class="report_option" name="report_option">
				<option>Playback Error</option>
				@if($issue->topic == 'tv')
				<option>Missing Episode</option>
				@endif
				<option>Incorrect Information</option>
				<option>Bad Quality</option>
				<option>Subtitles</option>
				<option>Other</option>
			</select>
		</div>
		<div class="col span_1_of_2">
			Describe it.
		</div>
		<textarea class="textarea-message" rows="3" name="issue_description" placeholder="Type message here..." minlength="2"></textarea>

		{{-- TV --}}

		@if($issue->topic == 'tv')

		<div class="col span_1_of_2">
			Which Season?
		</div>
		<div class="col span_1_of_2">
			<select class="season_option" name="season">
				@for ($i = 0; $i <= $last_season_number; $i++)
					@if($i == 0)
					<option value="{{ $i }}" label="Specials">
					@else
					<option value="{{ $i }}" label="Season {{ $i }}">
					@endif
					</option>
				@endfor
			</select>
		</div>
		<div class="col span_1_of_2">
			Which Episode?
		</div>
		<div class="col span_1_of_2">
			<select class="episode_option" name="episode">
				@foreach ($first_season_episodes as $episodes)
					@foreach ($episodes as $episode)
						<option value="{{ $episode['episode_number'] }}" label="Episode {{ $episode['episode_number'] }} - {{ $episode['name'] }}">
					@endforeach
				@endforeach
			</select>
		</div>
		@endif
		{{-- <div class="col span_1_of_2">
		</div> --}}

		{{-- MUSIC --}}

		{{-- @if($issue->topic == 'music')
		<div class="section group">
			<div class="col span_1_of_2">
				Track Listing
			</div>
			<div class="col span_1_of_2">
				Track Title
			</div>
			<div class="col span_1_of_2">
				Track Title
			</div>
			<div class="col span_1_of_2">
				Track Title
			</div>
			<div class="col span_1_of_2">
				Track Title
			</div>
		</div>
		@endif --}}

	</div>


	{{-- <input type="hidden" id="token" 		value="{{ csrf_token() }}"> --}}
	<input type="hidden" name="title" 			value="{{ $issue->content }}">
	<input type="hidden" name="tmdb" 			value="{{ $issue->tmdb }}">
	<input type="hidden" name="poster" 			value="{{ $issue->poster_url }}">
	<input type="hidden" name="backdrop" 		value="{{ $issue->backdrop_url }}">
	<input type="hidden" name="topic" 			value="{{ $issue->topic }}">
	<input type="hidden" name="vote_average" 	value="{{ $issue->vote_average }}">
	<input type="hidden" name="round" 			value="advanced">
	<div class="search__request__full">
	    <button type="submit" name="type" value="issue" class="btn">Report</button>
	</div>

</form>

</div>

@stop
