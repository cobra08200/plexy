@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="cd-fold-content single-page">
	<em>{{ $issue->content }}</em>
	<img src="{{ $issue->poster_url }}" width="100%" alt="{{ $issue->content }}">

	{{ Form::open(array('route' => 'api.search')) }}

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
			Which episode?
		</div>
		<div class="col span_1_of_2">
			<select class="season_episode_option" name="season_episode">
				@for ($i = 0; $i <= $seasons_total; $i++)
					@if($i == 0)
					<optgroup label="Specials">
					@else
					<optgroup label="Season {{ $i }}">
					@endif
					@foreach($episodes_collection as $episode)
						@if($episode->season_number == $i)
							{{-- <option>Episode {{ $episode->episode_number }} - {{ $episode->name}}</option> --}}
							@if($episode->season_number < 10 && $episode->episode_number < 10)
							<option value="{{ $episode->season_number }}|{{ $episode->episode_number }}">S0{{ $episode->season_number }}E0{{ $episode->episode_number }} - {{ $episode->name}}</option>
							@elseif($episode->season_number < 10 && $episode->episode_number >= 10)
							<option value="{{ $episode->season_number }}|{{ $episode->episode_number }}">S0{{ $episode->season_number }}E{{ $episode->episode_number }} - {{ $episode->name}}</option>
							@elseif($episode->season_number >= 10 && $episode->episode_number >= 10)
							<option value="{{ $episode->season_number }}|{{ $episode->episode_number }}">S{{ $episode->season_number }}E{{ $episode->episode_number }} - {{ $episode->name}}</option>
							@elseif($episode->season_number >= 10 && $episode->episode_number < 10)
							<option value="{{ $episode->season_number }}|{{ $episode->episode_number }}">S{{ $episode->season_number }}E0{{ $episode->episode_number }} - {{ $episode->name}}</option>
							@endif
						@endif
					@endforeach
					</optgroup>
				@endfor
				{{-- <option>All Episodes</option> --}}
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
	{{ Form::close() }}

</div>

@stop
