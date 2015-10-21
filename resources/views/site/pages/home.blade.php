@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<header id="title_big">PLEXY</header>

{{-- @if(!$user->hasRole("admin")) --}}

    @include('site/layouts/partials/search')

{{-- @endif --}}

    @if(count($movie_requests) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $movie_requests, 'header' => 'MOVIE REQUESTS'])
    @endif

    @if(count($tv_requests) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $tv_requests, 'header' => 'TV REQUESTS'])
    @endif

    @if(count($music_requests) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $music_requests, 'header' => 'MUSIC REQUESTS'])
    @endif

    @if(count($movie_issues) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $movie_issues, 'header' => 'MOVIE ISSUES'])
	@endif

	@if(count($tv_issues) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $tv_issues, 'header' => 'TV ISSUES'])
    @endif

	@if(count($music_issues) > 0 )
        @include('site/layouts/partials/issue_request_module', ['module' => $music_issues, 'header' => 'MUSIC ISSUES'])
    @endif

	@if(count($closed) > 0)
        @include('site/layouts/partials/issue_request_module', ['module' => $closed, 'header' => 'CLOSED'])
    	{{$closed->links()}}
	@endif



@if(count($movie_requests) + count($movie_issues) + count($tv_requests) + count($tv_issues) + count($closed) == 0)
    ADD SOMETHING
@endif

@stop

@section('scripts')

<script>
// jQuery("#title_big").fitText();

// $('#searcher').submit(function() {
//     if ($.trim($("#tmdb").val()) === "") {
//         alert('you did not fill out one of the fields');
//         return false;
//     }
// });

// $('#searcher').submit(function () {
//
//     // Get the Login Name value and trim it
//     var checkthat = $.trim($('#tmdb').val());
// 	console.log(checkthat);
//
//     // Check if empty of not
//     if (checkthat === '') {
//         alert('Text-field is empty.');
//         return false;
//     }
// });

// $( "#searcher" ).on( "submit", function() {
//
//    var has_empty = false;
//
//    $(this).find( 'input[type!="hidden"]' ).each(function () {
//
//       if ( ! $(this).val() ) { has_empty = true; return false; }
//    });
//
//    if ( has_empty ) { return false; }
// });

var movies = new Bloodhound({
	datumTokenizer: function (datum) {
		return Bloodhound.tokenizers.whitespace(datum.value);
	},
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	limit: 8,
	remote: {
		@if(App::environment('production'))
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
							@if(App::environment('production'))
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
		@if(App::environment('production'))
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
                            @if(App::environment('production'))
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
		@if(App::environment('production'))
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

// console.log(('#searcher').attr('action'));
// $( '#issue_button' ).click( function(e) {
// e.preventDefault();
// 	$.ajax({
// 	    type: "POST",
// 	    url: '{{URL::route('search.submit')}}',
// 	    // data: $(this).serialize(),
// 		data: {
// 			'_token': token
// 		},
// 		success: function(data) {
//         	console.log(data);
// 	    },
// 		error: function() {
// 	        console.log("error!!!!");
// 	    }
// 	});
// });

// $('#issue_button').submit(function(e) {
//     e.preventDefault();
//
//     $.post('categories', {_token: '{{ csrf_token() }}'}, function(data) {
//         console.log(data);
//     });
// });

// $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
// });

// var gallery = $('.cd-gallery'),
// 	foldingPanel = $('.cd-folding-panel'),
// 	mainContent = $('.cd-main')
// 	data = 'dingo';
//
// /* close folding content */
// foldingPanel.on('click', '.cd-close', function(event){
// 	event.preventDefault();
// 	$('.cd-fold-content').empty();
// 	toggleContent(data, false);
// });
//
// gallery.on('click', function(event){
// 	/* detect click on .cd-gallery::before when the .cd-folding-panel is open */
// 	if($(event.target).is('.cd-gallery') && $('.fold-is-open').length > 0 ) toggleContent(data, false);
// })
//
// $("#issue_button").on('click', function(e) {
// 	e.preventDefault();
//
// 	var issue_search = {
// 			year:			$("#year").val(),
// 			tmdb: 			$("#tmdb").val(),
// 			poster: 		$("#poster").val(),
// 			backdrop: 		$("#backdrop").val(),
// 			topic: 			$("#topic").val(),
// 			vote_average: 	$("#vote_average").val(),
// 			title: 			$("#title").val(),
// 			type: 			'issue'
// 		},
//
// 		$issueButton = $(e.currentTarget),
// 		$form = $issueButton.closest('form');
//
// 	if ( failsJQueryValidation($form) ) { return; }
//
// 	$.ajax({
// 		url: '{{ URL::route('search.submit') }}',
// 		type: 'post',
// 		data: issue_search,
// 		// dataType: 'json',
// 		success: function(data, textStatus, bool) {
// 			// $('.cd-fold-content').html(data);
// 			// console.log(data);
// 			openItemInfo(data);
//
// 			function openItemInfo(data) {
// 				var mq = viewportSize();
// 				toggleContent(data, true);
// 			}
// 	    },
// 	    error: function() {
// 	        alert('Not O.K.');
// 	    }
// 	});
// });

// function failsJQueryValidation ($form) {
//     return ('valid' in $form) && (!$form.valid());
// }
//
// function toggleContent(data, bool) {
//    /* load and show new content */
//    var foldingContent = foldingPanel.find('.cd-fold-content');
//
//    if (bool) {
//        foldingContent.append(data);
//        setTimeout(function(){
//            $('body').addClass('overflow-hidden');
//            foldingPanel.addClass('is-open');
//            mainContent.addClass('fold-is-open');
//        });
//    } else {
// 	   /* close the folding panel */
// 	   var mq = viewportSize();
// 	   $('body').removeClass('overflow-hidden');
// 	   foldingPanel.removeClass('is-open');
// 	   mainContent.removeClass('fold-is-open');
//
// 	   (mq == 'mobile' || $('.no-csstransitions').length > 0 )
// 		   /* according to the mq, immediately remove the .overflow-hidden or wait for the end of the animation */
// 		   ? $('body').removeClass('overflow-hidden')
//
// 		   : mainContent.find('.cd-item').eq(0).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
// 			   $('body').removeClass('overflow-hidden');
// 			   mainContent.find('.cd-item').eq(0).off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
// 		   });
//    }
// }

// function toggleContent(data, bool) {
// 	if( bool ) {
// 		/* load and show new content */
// 		var foldingContent = foldingPanel.find('.cd-fold-content');

		// $('.cd-fold-content').html(data);
		// $('body').addClass('overflow-hidden');
		// foldingPanel.addClass('is-open');
		// mainContent.addClass('fold-is-open');




		// function slowView(){
		// 	$('body').addClass('overflow-hidden');
		// 	foldingPanel.addClass('is-open');
		// 	mainContent.addClass('fold-is-open');
		// 	$('.cd-fold-content').html(data);
		// }
		// setTimeout(slowView, 100);

		// animation
		// foldingContent.load(data+' .cd-fold-content > *', function(event){
// 		foldingContent.append(data);
// 			setTimeout(function(){
// 				$('body').addClass('overflow-hidden');
// 				foldingPanel.addClass('is-open');
// 				mainContent.addClass('fold-is-open');
// 			}, 100);
// 		});
//
// 	} else {
// 		/* close the folding panel */
// 		var mq = viewportSize();
// 		$('body').removeClass('overflow-hidden');
// 		foldingPanel.removeClass('is-open');
// 		mainContent.removeClass('fold-is-open');
//
// 		(mq == 'mobile' || $('.no-csstransitions').length > 0 )
// 			/* according to the mq, immediately remove the .overflow-hidden or wait for the end of the animation */
// 			? $('body').removeClass('overflow-hidden')
//
// 			: mainContent.find('.cd-item').eq(0).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
// 				$('body').removeClass('overflow-hidden');
// 				mainContent.find('.cd-item').eq(0).off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
// 			});
// 	}
//
// }

// function viewportSize() {
// 	/* retrieve the content value of .cd-main::before to check the actual mq */
// 	return window.getComputedStyle(document.querySelector('.cd-main'), '::before').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "");
// }

</script>

@stop
