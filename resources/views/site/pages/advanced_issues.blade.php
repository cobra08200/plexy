@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="cd-fold-content single-page">
	<p>{{ $issue->content }}@if($issue->topic == 'music') - {{ $tracks[0]['artists'][0]['name'] }}@endif</p>
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
				@if($issue->topic != 'music')
				<option>Subtitles</option>
				@endif
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
			<select class="season_option" id="season_option" name="season">
				@for ($i = $first_season_number; $i <= $last_season_number; $i++)
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
			<select class="episode_option" id="episode_option" name="episode">
				@for ($i = $first_season_number; $i <= $first_season_number; $i++)
					@foreach($series as $episode)
						@if($i == $episode['parentIndex'])
						<option value="{{ $episode['index'] }}" label="Episode {{ $episode['index'] }}">
						@endif
						</option>
					@endforeach
				@endfor
			</select>
		</div>
		{{-- <div class="col span_1_of_2">
			<select class="episode_option" id="episode_option" name="episode">
				@foreach ($first_season_episodes as $episodes)
					@foreach ($episodes as $episode)
						<option value="{{ $episode['episode_number'] }}" label="Episode {{ $episode['episode_number'] }}">
					@endforeach
				@endforeach
			</select>
		</div> --}}
		@endif

		{{-- MUSIC --}}

		@if($issue->topic == 'music')
		<div class="section group">
			<div class="col span_1_of_2">
				Track Listing
			</div>
			<div class="col span_1_of_2">
				<select class="tracklist_option" name="tracklist_option" name="track">
					@foreach ($tracks as $track)
						<option value="{{ $track['track_number'] }}" label="{{ $track['name'] }}">
							{{-- {{ $track['track_number'] }}. {{ $track['name'] }}
							<audio controls>
								<source src="{{ $track['preview_url'] }}" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio> --}}
					@endforeach
				</select>
			</div>
		</div>
		@endif

	</div>

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

@section('scripts')

<script>
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$('.season_option').on('change',function()
{
	var selectedSeason=$(this).find('option:selected').val();
	$.ajax({
		url:'{{ url('search/tv/series/') }}/{{ $issue->tmdb }}/season/'+selectedSeason,
		type:'POST',
		dataType:'json',
		contentType: "application/json",
		data: JSON.stringify(selectedSeason),
		success: function (data) {
			$('#episode_option').empty();
		    $.each(data.episodes, function (value) {
				console.log(value + 1);
				var newValue = parseInt(value) + 1;
				$('#episode_option').append('<option value="' + newValue + '">Episode ' + newValue + '</option>');
		    });
		},
		error: function (data) {
		    // display any unhandled error
		}
	});
});
</script>

@endsection
