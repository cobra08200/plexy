@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<form class="" action="{{ route('search.submit') }}" method="post">

	<div class="ui card">

	  <div class="content">
			<p class="header">{{ $issue->content }}</p>
	  </div>

	  <div class="image">
	    <img src="{{ $issue->poster_url }}" alt="{{ $issue->content }}">
	  </div>

		{!! csrf_field() !!}

	  <div class="content">
			<select name="report_option" class="ui fluid dropdown report_option" id="report_option">
			  <option value="">What's up?</option>
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

		<div class="extra content">
	    <div class="ui large transparent input">
	      <input type="text" name="issue_description" placeholder="Describe it..." minlength="2">
	    </div>
	  </div>

		{{-- TV --}}

		@if ($issue->topic == 'tv')
		<div class="extra content">
			<select name="season" class="ui fluid dropdown season_option" id="season_option">
			  <option value="">Which Season?</option>
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
		<div class="extra content">
			<select name="episode" class="ui fluid dropdown episode_option" id="episode_option">
				<option value="">Which Season?</option>
				@foreach ($series as $episode)
					@if ($first_season_number == $episode['parentIndex'])
					<option value="{{ $episode['index'] }}" label="Episode {{ $episode['index'] }}">
					@endif
					</option>
				@endforeach
			</select>
		</div>
		@endif

		{{-- MUSIC --}}

		@if ($issue->topic == 'music')
		<div class="extra content">
			<select name="track" class="ui fluid dropdown tracklist_option" id="tracklist_option">
				<option value="">Which track?</option>
				@foreach ($album as $track)
					<option value="{{ $track['index'] }}" label="{{ $track['index'] }}. {{ $track['title'] }}">
				@endforeach
			</select>
		</div>
		@endif

		<input type="hidden" name="title" 				value="{{ $issue->content }}">
		<input type="hidden" name="tmdb" 					value="{{ $issue->tmdb }}">
		<input type="hidden" name="poster" 				value="{{ $issue->poster_url }}">
		<input type="hidden" name="backdrop" 			value="{{ $issue->backdrop_url }}">
		<input type="hidden" name="topic" 				value="{{ $issue->topic }}">
		<input type="hidden" name="vote_average" 	value="{{ $issue->vote_average }}">
		<input type="hidden" name="round" 				value="advanced">
		<div class="search__request__full">
			<button type="submit" id="submit_button" name="type" value="issue" class="btn">Report</button>
		</div>

</div>

</form>

@stop

@section('scripts')

<script>
$('#report_option')
  .dropdown()
;

$('#season_option')
  .dropdown()
;

$('#episode_option')
  .dropdown()
;

$('#tracklist_option')
  .dropdown()
;

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
