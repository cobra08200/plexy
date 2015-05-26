@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="container-fluid">
  <div class="row">
    @if(!$user->hasRole("admin"))
    <div class="search">
        @include('site/layouts/partials/search')
    </div>
    @endif

    @if($user->hasRole("admin"))
    <div class="dashboard__tab dashboard__tab-admin" data-tab>
    @else
    <div class="dashboard__tab dashboard__tab-user" data-tab>
    @endif

      <ul class="dashboard__tabs">
          @if(count($requests) > 0 )
          <li><a href="#tab-requests">Requests</a></li>
          @endif
          @if(count($issues) > 0)
          <li><a href="#tab-issues">Issues</a></li>
          @endif
          @if(count($closed) > 0)
          <li><a href="#tab-finished">Finished</a></li>
          @endif
      </ul>

      @if(count($requests) > 0)
      <div id="tab-requests">

      <h3 class="page-header">Requests</h3>

      @foreach($requests->all() as $request)
      <div class="media placeholders">
        <a href="{{ URL::to('issue') }}/{{ $request->id }}" data-target="#plexyModal">
            <img src="{{ $request->poster_url }}">
        </a>
        <h4>{{ $request->content }}</h4>
        <kbd>{{ $request->status }}</kbd>
      </div>
      @endforeach

      </div>
      @endif

      @if(count($issues) > 0)
      <div id="tab-issues">

      <h3 class="page-header">Issues</h3>

      @foreach($issues->all() as $issue)
        <div class="media placeholders">
            <a href="{{ URL::to('issue') }}/{{ $issue->id }}" data-target="#plexyModal">
                <img src="{{ $issue->poster_url }}">
            </a>
            <h4>{{ $issue->content }}</h4>
            <kbd>{{ $issue->status }}</kbd>
        </div>
      @endforeach

      </div>
      @endif

      @if(count($closed) > 0)
      <div id="tab-finished">

      <h3 class="page-header">Finished</h3>

      @foreach($closed->all() as $close)
        <div class="media placeholders">
            <a href="{{ URL::to('issue') }}/{{ $close->id }}" data-target="#plexyModal">
                <img src="{{ $close->poster_url }}" height="200">
            </a>
            <h4>{{ $close->content }}</h4>
            <kbd>{{ $close->status }}</kbd>
        </div>
      @endforeach

      </div>
      @endif

      @if(count($requests) + count($issues) + count($closed) == 0)
      <p>Add something you dingo</p>
      @endif

  </div>

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
                if (movie.release_date) {
    				return {
    					tmdb: movie.id,
    					value: movie.original_title,
    					year: movie.release_date,
                        poster_path: (movie.poster_path !== null ? 'http://image.tmdb.org/t/p/w500' + movie.poster_path : '{{asset('assets/img/no-poster.jpg')}}'),
    					backdrop_path: (movie.backdrop_path !== null ? 'http://image.tmdb.org/t/p/w500' + movie.backdrop_path : '{{asset('assets/img/no-backdrop.jpg')}}'),
    					vote_average: movie.vote_average,
    					media_type: 'movie'
    				};
                }
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
                if (tvshow.first_air_date) {
    				return {
    					tmdb: tvshow.id,
    					value: tvshow.name,
    					year: tvshow.first_air_date,
    					poster_path: (tvshow.poster_path !== null ? 'http://image.tmdb.org/t/p/w500' + tvshow.poster_path : '{{asset('assets/img/no-poster.jpg')}}'),
    					backdrop_path: (tvshow.backdrop_path !== null ? 'http://image.tmdb.org/t/p/w500' + tvshow.backdrop_path : '{{asset('assets/img/no-backdrop.jpg')}}'),
    					vote_average: tvshow.vote_average,
    					media_type: 'tv'
    				};
                }
			});
		}
	}
});

// Initialize the Bloodhound suggestion engine
movies.initialize();
tvshows.initialize();

// console.log(movies, movies.initialize());

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
		suggestion: Handlebars.compile('<p class="tt__list-item"><img class="tt__list-item-image" src="@{{poster_path}}" alt="Poster of @{{value}}"/><strong>@{{value}}</strong> – @{{year}}</p>')
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
		suggestion: Handlebars.compile('<p class="tt__list-item"><img class="tt__list-item-image" src="@{{poster_path}}" alt="Poster of @{{value}}"/><strong>@{{value}}</strong> – @{{year}}</p>')
	}

// binding disabled for multi dataset testing
}).bind("typeahead:selected", function (obj, datum, name)
{
	$( '#title' ).val(datum.value);
	$( '#year' ).val(datum.year);
	$( '#tmdb' ).val(datum.tmdb);
    $( '#poster' ).val(datum.poster_path);
    $( '#backdrop' ).val(datum.backdrop_path);
	$( '#topic' ).val(datum.media_type);
	$( '#vote_average' ).val(datum.vote_average);
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

// intialize dashboard tabs
$(document).ready(function () {

    var $dataTabs = $('[data-tab]'),
        $modalLinks = '[data-target="#plexyModal"]',
        $modal = $('[data-plexyModal]');

    // Init jquery tabs on home view
    $dataTabs.tabs();

    // open modal links
    $(document).on('click', $modalLinks, function(e) {
        e.preventDefault(); //  prevent default click

        var $issue = $(this),
            issueURL = $issue.attr('href');

        $modal
            .find('.modal-body')
            .empty()
            .load(issueURL)
        .end()
            .modal();
        console.log($modal.find('.modal-body'));
            return false;
    });
});

</script>
@stop
