@extends('admin.layouts.default')

@section('content')

<div class="row">

{{--
	<h3>
		@if($user->hasRole("comment"))
		My
		@endif
		Requests
	</h3>
--}}
{{--
		<table class="table">
			<thead>
				<tr>
					@if($user->hasRole("admin"))
					<th><input type="text" class="form-control" placeholder="User"></th>
					<th>
						<select class="form-control" id="status">
							<option>all statuses</option>
							<option>open</option>
							<option>pending</option>
							<option>closed</option>
						</select>
					</th>
					@endif
					
				</tr>
			</thead>
			<tbody>
				@foreach($issues as $issue)
				@if($issue->status === 'closed')
				<tr class="clickableRow" href="{{ URL::to('issue') }}/{{ $issue->id }}">
				@else
				<tr class="clickableRow" href="{{ URL::to('issue') }}/{{ $issue->id }}">
					@endif
					@if($user->hasRole("admin"))
					<td data-title="User">{{ $issue->owner->username }}</td>
					<td data-title="Status">{{ $issue->status }}</td>
					@endif
					{{--
					<td data-title="Topic">{{ $issue->topic }}</td>
					--}}
					{{--
					<td data-title="Content">{{ $issue->content }}</td>
					<td data-title="Created">{{ $issue->created_at->diffForHumans() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
--}}

	{{ Form::open(array('route' => 'movies.search')) }}
	{{ Form::text('title', '', array('class' => 'typeahead form-control','placeholder' => 'Title')) }}
	{{ Form::hidden('title', '', array('id' => 'title')) }}
	{{ Form::hidden('year', '', array('id' => 'year')) }}
	{{ Form::hidden('tmdb', '', array('id' => 'tmdb')) }}
	{{ Form::hidden('poster', '', array('id' => 'poster')) }}
	{{ Form::hidden('backdrop', '', array('id' => 'backdrop')) }}
	{{ Form::hidden('topic', '', array('id' => 'topic')) }}
	{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}


	@foreach(array_chunk($issues->all(), 4) as $issue_row)
		<div class="row-fluid">
			@foreach ($issue_row as $issue)
			<a href="{{ URL::to('issue') }}/{{ $issue->id }}">
				<img class="img-zoom" src="{{ $issue->poster_url }}" width="150">
			</a>
			@endforeach
		</div>
	@endforeach
	{{ $issues->appends(Request::except('page'))->links() }}

</div>

@stop

@section('scripts')

<script>
	jQuery(document).ready(function($) {
		$(".clickableRow").click(function() {
			window.document.location = $(this).attr("href");
		});
	});


//movies search
var movies = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 5,
	remote: {
		url: 'http://api.themoviedb.org/3/search/movie?api_key=470fd2ec8853e25d2f8d86f685d2270e&query=%QUERY&include_adult=false&search_type=ngram',
		filter: function (movies) {
			// Map the remote source JSON array to a JavaScript array
			return $.map(movies.results, function (movie) {
				return {
					tmdb: movie.id,
					value: movie.original_title,
					year: (movie.release_date.substr(0, 4) ? movie.release_date.substr(0, 4) : ''),
					poster_path: movie.poster_path,
					backdrop_path: movie.backdrop_path,
					media_type: 'movie'
				};
			});
		}
	}
});

//tv search
//movies search
var tvshows = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 5,
	remote: {
		url: 'http://api.themoviedb.org/3/search/tv?api_key=470fd2ec8853e25d2f8d86f685d2270e&query=%QUERY&include_adult=false&search_type=ngram',
		filter: function (tvshows) {
			// Map the remote source JSON array to a JavaScript array
			return $.map(tvshows.results, function (tvshow) {
				return {
					tmdb: tvshow.id,
					value: tvshow.name,
					year: (tvshow.first_air_date.substr(0, 4) ? tvshow.first_air_date.substr(0, 4) : ''),
					poster_path: tvshow.poster_path,
					backdrop_path: tvshow.backdrop_path,
					media_type: 'tv'
				};
			});
		}
	}
});

// Initialize the Bloodhound suggestion engine
movies.initialize();
tvshows.initialize();

// Instantiate the Typeahead UI
$('.typeahead').typeahead(
{
	hint: true,
	highlight: true
},
{
	name: 'movies',
	displayKey: 'value',
	source: movies.ttAdapter(),
	templates:
	{
		header: '<h3 class="dropdown-header">movies</h3>',
		empty: [
		'<div class="empty-message">',
		'You goofed.',
		'</div>'].join('\n'),
		suggestion: Handlebars.compile('<p><strong>@{{value}}</strong> – @{{year}}</p>')
	}
},
{
	name: 'tvshows',
	displayKey: 'value',
	source: tvshows.ttAdapter(),
	templates:
	{
		header: '<h3 class="dropdown-header">tv shows</h3>',
		empty: [
		'<div class="empty-message">',
		'You goofed.',
		'</div>'].join('\n'),
		suggestion: Handlebars.compile('<p><strong>@{{value}}</strong> – @{{year}}</p>')
	}

// binding disabled for multi dataset testing
}).bind("typeahead:selected", function (obj, datum, name)
{
	$( '#title' ).val(datum.value);
	$( '#year' ).val(datum.year);
	$( '#tmdb' ).val(datum.tmdb);
	$( '#poster' ).val('http://image.tmdb.org/t/p/w500' + datum.poster_path);
	$( '#backdrop' ).val('http://image.tmdb.org/t/p/w500' + datum.backdrop_path);
	$( '#topic' ).val(datum.media_type);
});


// $(document).ready(function(){
// 	$('.img-zoom').hover(function() {
// 		$(this).addClass('transition');

// 	}, function() {
// 		$(this).removeClass('transition');
// 	});
// });

</script>
@stop
