@extends('site.layouts.default')

@section('content')

<div class="container-fluid">
  <div class="row">
    @if($user->hasRole("admin"))
    @else
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        @include('site/layouts/partials/search')
      </ul>
    </div>
    @endif

    @if($user->hasRole("admin"))
    <div class="col-sm-12 main">
    @else
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    @endif

      <h1 class="page-header">Requests</h1>

      @foreach(array_chunk($requests->all(), 4) as $request_row)
        <div class="row placeholders">
          @foreach ($request_row as $request)
          <div class="col-xs-6 col-sm-3">
            <a href="{{ URL::to('issue') }}/{{ $request->id }}">
            <img src="{{ $request->poster_url }}" height="200">
            </a>
            <h4>{{ $request->content }}</h4>
            <kbd>{{ $request->status }}</kbd>
          </div>
          @endforeach
        </div>
      @endforeach

      <h1 class="page-header">Issues</h1>

      @foreach(array_chunk($issues->all(), 4) as $issue_row)
        <div class="row placeholders">
          @foreach ($issue_row as $issue)
          <div class="col-xs-6 col-sm-3">
            <a href="{{ URL::to('issue') }}/{{ $issue->id }}">
            <img src="{{ $issue->poster_url }}" height="200">
            </a>
            <h4>{{ $issue->content }}</h4>
            <kbd>{{ $issue->status }}</kbd>
          </div>
          @endforeach
        </div>
      @endforeach

      <h1 class="page-header">Finished</h1>

      @foreach(array_chunk($closed->all(), 4) as $closed_row)
        <div class="row placeholders">
          @foreach ($closed_row as $close)
          <div class="col-xs-6 col-sm-3">
            <a href="{{ URL::to('issue') }}/{{ $close->id }}">
            <img src="{{ $close->poster_url }}" height="200">
            </a>
            <h4>{{ $close->content }}</h4>
            <kbd>{{ $close->status }}</kbd>
          </div>
          @endforeach
        </div>
      @endforeach

{{-- Optional Table View (Probably for Admin View)
      <h2 class="sub-header">Table</h2>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              @if($user->hasRole("admin"))
              <th>User</th>
              @endif
              <th>Status</th>
              <th>Title</th>
              <th>Added</th>
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
              @endif
              <td data-title="Status">{{ $issue->status }}</td>
              <td data-title="Content">{{ $issue->content }}</td>
              <td data-title="Created">{{ $issue->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
--}}

	{{ $issues->appends(Request::except('page'))->links() }}

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
