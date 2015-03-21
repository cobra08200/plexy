<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>

	<style type="text/css">

		.tt-dropdown-menu {
			background-color: #FFFFFF;
			border: 1px solid rgba(0, 0, 0, 0.2);
			border-radius: 8px 8px 8px 8px;
			box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
			margin-top: 12px;
			padding: 8px 0;
			width: 422px;
		}
		.tt-suggestion.tt-cursor {
			background-color: #0097CF;
			color: #FFFFFF;
		}
		.tt-suggestion p {
			margin: 0;
		}
		.gist {
			font-size: 14px;
		}

		#multiple-datasets .league-name {
			margin: 0 20px 5px 20px;
			padding: 3px 0;
			border-bottom: 1px solid #ccc;
		}
	</style>
</head>

<body>

	<div id="movie">
		{{ Form::open(array('route' => 'movies.search')) }}
		{{ Form::select('topic', array('miscellaneous' => 'Miscellaneous', 'movies' => 'Movies', 'music' => 'Music', 'tv' => 'TV'), 'miscellaneous') }}
		{{ Form::text('title', '', array('class' => 'typeahead' ,'placeholder' => 'Title')) }}

		{{ Form::hidden('year', 'Year', array('id' => 'year')) }}
		{{ Form::hidden('movieid', 'MovieID', array('id' => 'movieid')) }}
		{{ Form::hidden('img', 'Image', array('id' => 'img')) }}
		{{ Form::submit('go'); }}

		{{ Form::close() }}
	</div>

	{{--<div id="tv">
		{{ Form::open(array('route' => 'movies.search')) }}

		{{ Form::text('title', '', array('class' => 'typeahead' ,'placeholder' => 'Title')) }}

		{{ Form::hidden('year', 'Year', array('id' => 'year')) }}
		{{ Form::hidden('movieid', 'MovieID', array('id' => 'movieid')) }}
		{{ Form::hidden('img', 'Image', array('id' => 'img')) }}
		{{ Form::submit('go'); }}

		{{ Form::close() }}
	</div>--}}
</body>


</html>

<script>
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
					movieid: movie.id,
					value: movie.original_title,
					year: (movie.release_date.substr(0, 4) ? movie.release_date.substr(0, 4) : ''),
					poster_path: movie.poster_path
				};
			});
		}
	}
});

// Initialize the Bloodhound suggestion engine
movies.initialize();
// tv.initialize();

// Instantiate the Typeahead UI
$('.typeahead').typeahead(
{
	hint: true,
	highlight: true
},
{
	displayKey: 'value',
	source: movies.ttAdapter(),
	templates:
	{
		empty: [
		'<div class="empty-message">',
		'You goofed.',
		'</div>'].join('\n'),
		suggestion: Handlebars.compile('<p><strong>@{{value}}</strong> – @{{year}}</p>')
	}

}).bind("typeahead:selected", function (obj, datum, name)
{
	$( '#year' ).val(datum.year);
	$( '#movieid' ).val(datum.movieid);
	$( '#img' ).val('http://image.tmdb.org/t/p/w500' + datum.poster_path);
});

// custom div
$(document).ready(function()
{
	$("select").change(function()
	{
		$( "select option:selected").each(function()
		{
			if($(this).attr("value")=="red")
			{
				$(".box").hide();
				$(".red").show();
			}
			if($(this).attr("value")=="green")
			{
				$(".box").hide();
				$(".green").show();
			}
			if($(this).attr("value")=="blue")
			{
				$(".box").hide();
				$(".blue").show();
			}
		});
	}).change();
});

</script>

</body>
</html>
