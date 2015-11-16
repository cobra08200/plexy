@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="cd-fold-content single-page">
	<p>{{ $issue->content }}
		{{-- @if ($issue->topic == 'music')
			- {{ $tracks[0]['artists'][0]['name'] }}
		@endif --}}
	</p>
	<img src="{{ $issue->poster_url }}" width="200px" alt="{{ $issue->content }}">

	<form class="" action="{{ route('search.submit') }}" method="post">
	{!! csrf_field() !!}

	<div class="section group">
		<div class="col span_1_of_2">
			What's up?
		</div>
		<div class="col span_1_of_2">
			<select class="report_option" id="report_option" name="report_option">
				<option>Playback Error</option>
				@if ($issue->topic == 'tv')
				<option>Missing Episode</option>
				@endif
				@if ($issue->topic == 'music')
				<option>Missing Track</option>
				@endif
				<option>Incorrect Information</option>
				<option>Bad Quality</option>
				@if ($issue->topic != 'music')
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

		@if ($issue->topic == 'tv')

		<div class="col span_1_of_2">
			Which Season?
		</div>
		<div class="col span_1_of_2">
			<select class="season_option" id="season_option" name="season">
				@for ($i = $first_season_number; $i <= $last_season_number; $i++)
					@if ($i == 0)
					<option value="{{ $i }}" label="Specials">
					@else
					<option value="{{ $i }}" label="Season {{ $i }}">
					@endif
					</option>
				@endfor
			</select>
		</div>
		<div id="episodes">
			<div class="col span_1_of_2">
				Which Episode?
			</div>
			<div class="col span_1_of_2">
				<select class="episode_option" id="episode_option" name="episode">
						@foreach ($series as $episode)
							@if ($first_season_number == $episode['parentIndex'])
							<option value="{{ $episode['index'] }}" label="Episode {{ $episode['index'] }}">
							@endif
							</option>
						@endforeach
				</select>
			</div>
		</div>
		@endif

		{{-- MUSIC --}}

		@if ($issue->topic == 'music')
		<div id="tracklist">
			<div class="section group">
				<div class="col span_1_of_2">
					Which track?
				</div>
				<div class="col span_1_of_2">
					<select class="tracklist_option" id="tracklist_option" name="track">
						@foreach ($album as $track)
							<option value="{{ $track['index'] }}" label="{{ $track['index'] }}. {{ $track['title'] }}">
						@endforeach
					</select>
				</div>
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
	    <button type="submit" id="submit_button" name="type" value="issue" class="btn">Report</button>
	</div>

</form>

</div>

@stop

@section('scripts')

<script>
var $episodes = $('#episodes');
var $tracks = $('#tracklist');

$('.report_option').on('change',function() {
	if ($(this).val() == 'Missing Episode' || $(this).val() == 'Missing Track') {
		$episodes.hide();
		$tracks.hide();
	} else {
		$episodes.show();
		$tracks.show();
	}
});

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});
$('.season_option').on('change',function() {
	var selectedSeason=$(this).find('option:selected').val();
	$.ajax({
		url:'{{ url('plex/tv/') }}/{{ $issue->tmdb }}/season/'+selectedSeason+'/episodes',
		type:'POST',
		dataType:'json',
		contentType: "application/json",
		data: JSON.stringify(selectedSeason),
		success: function (data) {
			$('#episode_option').empty();
			for (var key in data) {
				if (data.hasOwnProperty(key)) {
					var obj = data[key];
					for (var prop in obj) {
						if (obj.hasOwnProperty(prop)) {
							if (prop == 'index') {
								$('#episode_option').append('<option value="' + obj[prop] + '">Episode ' + obj[prop] + '</option>');
							}
						}
					}
				}
			}
		},
		error: function (data) {
		}
	});
});
$(document)
    .ajaxStart(function () {
        $("#episode_option").prop("disabled", true);
        $("#submit_button").prop("disabled", true);
    })
    .ajaxStop(function () {
        $("#episode_option").prop("disabled", false);
        $("#submit_button").prop("disabled", false);
    });
</script>

@endsection
