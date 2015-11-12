var movies = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 8,
	remote: {
		@if (env('APP_ENV') == 'production')
		url: '{{ URL::to('search/movie', $secure) }}/%QUERY',
		@else
		url: '{{ URL::to('search/movie') }}/%QUERY',
		@endif
        filter: function (movies) {
			return $.map(movies.results, function (movie) {
                if (movie.release_date) {
                    if (movie.poster_path) {
        				return {
        					tmdb: movie.id,
        					value: movie.title,
        					year: (movie.release_date !== null ? movie.release_date.substr(0, 4) : ''),
							@if (env('APP_ENV') == 'production')
                            poster_path: (movie.poster_path !== null ? 'https://image.tmdb.org/t/p/w780' + movie.poster_path : '{{secure_asset('assets/img/no-poster.jpg')}}'),
        					backdrop_path: (movie.backdrop_path !== null ? 'https://image.tmdb.org/t/p/w780' + movie.backdrop_path : '{{secure_asset('assets/img/no-backdrop.jpg')}}'),
							@else
							poster_path: (movie.poster_path !== null ? 'http://image.tmdb.org/t/p/w780' + movie.poster_path : '{{asset('assets/img/no-poster.jpg')}}'),
        					backdrop_path: (movie.backdrop_path !== null ? 'http://image.tmdb.org/t/p/w780' + movie.backdrop_path : '{{asset('assets/img/no-backdrop.jpg')}}'),
							@endif
							vote_average: movie.vote_average,
        					media_type: 'movies'
        				};
                    }
                }
			});
		}
	}
});

var tvshows = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 8,
	remote: {
		@if (env('APP_ENV') == 'production')
		url: '{{ URL::to('search/tv', $secure) }}/%QUERY',
		@else
		url: '{{ URL::to('search/tv') }}/%QUERY',
		@endif
        filter: function (tvshows) {
			return $.map(tvshows.results, function (tvshow) {
                if (tvshow.first_air_date) {
                    if (tvshow.poster_path) {
        				return {
        					tmdb: tvshow.id,
        					value: tvshow.name,
        					year: (tvshow.first_air_date !== null ? tvshow.first_air_date.substr(0, 4) : ''),
                            @if (env('APP_ENV') == 'production')
        					poster_path: (tvshow.poster_path !== null ? 'https://image.tmdb.org/t/p/w780' + tvshow.poster_path : '{{secure_asset('assets/img/no-poster.jpg')}}'),
        					backdrop_path: (tvshow.backdrop_path !== null ? 'https://image.tmdb.org/t/p/w780' + tvshow.backdrop_path : '{{asset('assets/img/no-backdrop.jpg')}}'),
                            @else
                            poster_path: (tvshow.poster_path !== null ? 'http://image.tmdb.org/t/p/w780' + tvshow.poster_path : '{{asset('assets/img/no-poster.jpg')}}'),
        					backdrop_path: (tvshow.backdrop_path !== null ? 'http://image.tmdb.org/t/p/w780' + tvshow.backdrop_path : '{{asset('assets/img/no-backdrop.jpg')}}'),
                            @endif
                            vote_average: tvshow.vote_average,
        					media_type: 'tv'
        				};
                    }
                }
			});
		}
	}
});

var albums = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 8,
	remote: {
		@if (env('APP_ENV') == 'production')
		url: '{{ URL::to('search/music/album', $secure) }}/%QUERY',
		@else
		url: '{{ URL::to('search/music/album') }}/%QUERY',
		@endif
        filter: function (albums) {
			return $.map(albums.albums.items, function (album) {
				if (album.album_type == 'album') {
                	if (album.id) {
	    				return {
	    					tmdb: album.id,
							poster_path: album.images[0].url,
	    					value: album.name,
	    					media_type: 'music'
	    				};
	                }
                }
			});
		}
	}
});

movies.initialize();
tvshows.initialize();
albums.initialize();

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
		header: '<div class="dropdown-movie">MOVIES</div><div class="section group">',
		footer: '</div>',
		// empty: [
		// '<div class="dropdown-movie em">',
		// 'You goofed. Type something else.',
		// '</div>'].join('\n'),
		suggestion: Handlebars.compile('<div class="typeahead_col typeahead_span_1_of_4"><p class="tt__list-item"><img class="tt__list-item-image" src="@{{poster_path}}" alt="Poster of @{{value}}"/><br><strong>@{{value}}</strong> – @{{year}}</p></div>')
	}
},
{
	name: 'tvshows',
	displayKey: 'value',
	source: tvshows.ttAdapter(),
	templates:
	{
		header: '<div class="dropdown-tv">TV SHOWS</div><div class="section group">',
		footer: '</div>',
		// empty: [
		// '<div class="dropdown-tv em">',
		// 'You goofed. Type something else.',
		// '</div>'].join('\n'),
		suggestion: Handlebars.compile('<div class="typeahead_col typeahead_span_1_of_4"><p class="tt__list-item"><img class="tt__list-item-image" src="@{{poster_path}}" alt="Poster of @{{value}}"/><br><strong>@{{value}}</strong> – @{{year}}</p></div>')
	}
},
{
	name: 'albums',
	displayKey: 'value',
	source: albums.ttAdapter(),
	templates:
	{
		header: '<div class="dropdown-album">ALBUMS</div><div class="section group">',
		footer: '</div>',
		// empty: [
		// '<div class="dropdown-album em">',
		// 'You goofed. Type something else.',
		// '</div>'].join('\n'),
		suggestion: Handlebars.compile('<div class="typeahead_col typeahead_span_1_of_4"><p class="tt__list-item"><img class="tt__list-item-image" src="@{{poster_path}}" alt="Poster of @{{value}}"/><br><strong>@{{value}}</strong></p></div>')
	}
}).bind("typeahead:selected", function (obj, datum, name)
{
	$( '#title' ).val(datum.value);
	$( '#year' ).val(datum.year);
	$( '#tmdb' ).val(datum.tmdb);
    $( '#poster' ).val(datum.poster_path);
    $( '#backdrop' ).val(datum.backdrop_path);
	$( '#topic' ).val(datum.media_type);
	$( '#vote_average' ).val(datum.vote_average);
	$( "html, body" ).animate({scrollTop: 0 }, "slow");
// }).on('blur', function()
// {
// 	ev = $.Event("keydown");
// 	ev.keyCode = ev.which = 40;
// 	$('.typeahead').trigger(ev);
// 	return true;
});
