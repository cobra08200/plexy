@extends('site.layouts.default')

@section('content')

<div class="page-header">
  <h1>Test 1 <small>Table</small></h1>
</div>

<div class="row">

	<h3>
		@if($user->hasRole("comment"))
		My
		@endif
		Requests
	</h3>

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
					<td data-title="Topic">{{ $issue->topic }}</td>
					<td data-title="Content">{{ $issue->content }}</td>
					<td data-title="Created">{{ $issue->created_at->diffForHumans() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

<div class="page-header">
  <h1>Test 2 <small>Posters</small></h1>
</div>

	@foreach(array_chunk($issues->all(), 4) as $issue_row)
		<div class="row-fluid">
			@foreach ($issue_row as $issue)
			<p>
				{{ $issue->type }}
			</p>
			<a href="{{ URL::to('issue') }}/{{ $issue->id }}">
				<img class="img-zoom" src="{{ $issue->poster_url }}" width="150" data-toggle="tooltip" data-placement="top" title="{{ $issue->content }}">
			</a>
			@endforeach
		</div>
	@endforeach
	{{ $issues->appends(Request::except('page'))->links() }}

</div>

<div class="page-header">
  <h1>Test 3 <small>Other thing</small></h1>
</div>

<div class="container">

    <hgroup class="mb20">
		<h1>Search Results</h1>
		<h2 class="lead"><strong class="text-danger">3</strong> results were found for the search for <strong class="text-danger">Lorem</strong></h2>
	</hgroup>

    <section class="col-xs-12 col-sm-6 col-md-12">

		<article class="request-result row">
			<div class="col-xs-12 col-sm-12 col-md-3">
				<a href="#" title="Lorem ipsum" class="thumbnail"><img src="http://lorempixel.com/250/140/people" alt="Lorem ipsum" /></a>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2">
				<ul class="meta-search">
					<li><i class="glyphicon glyphicon-calendar"></i> <span>02/15/2014</span></li>
					<li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
					<li><i class="glyphicon glyphicon-tags"></i> <span>People</span></li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-7 excerpet">
				<h3><a href="#" title="">Voluptatem, exercitationem, suscipit, distinctio</a></h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, exercitationem, suscipit, distinctio, qui sapiente aspernatur molestiae non corporis magni sit sequi iusto debitis delectus doloremque.</p>
                <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
			</div>
			<span class="clearfix borda"></span>
		</article>

	</section>
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
		url: 'http://api.themoviedb.org/3/search/movie?api_key=a31dbc04c5cc13fd61e1427d4ff1cd58&query=%QUERY&include_adult=false&search_type=ngram',
		filter: function (movies) {
			// Map the remote source JSON array to a JavaScript array
			return $.map(movies.results, function (movie) {
				return {
					tmdb: movie.id,
					value: movie.original_title,
					year: (movie.release_date !== null ? movie.release_date.substr(0, 4) : ''),
					poster_path: movie.poster_path,
					backdrop_path: movie.backdrop_path,
					vote_average: movie.vote_average,
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
		url: 'http://api.themoviedb.org/3/search/tv?api_key=a31dbc04c5cc13fd61e1427d4ff1cd58&query=%QUERY&include_adult=false&search_type=ngram',
		filter: function (tvshows) {
			// Map the remote source JSON array to a JavaScript array
			return $.map(tvshows.results, function (tvshow) {
				return {
					tmdb: tvshow.id,
					value: tvshow.name,
					year: (tvshow.first_air_date !== null ? tvshow.first_air_date.substr(0, 4) : ''),
					poster_path: tvshow.poster_path,
					backdrop_path: tvshow.backdrop_path,
					vote_average: tvshow.vote_average,
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
	$( '#vote_average' ).val(datum.vote_average);
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>
@stop
