<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.4/typeahead.bundle.min.js"></script>
	
	<style type="text/css">
		@font-face {
			font-family:"Prociono";
			src: url("../font/Prociono-Regular-webfont.ttf");
		}
		html {
			overflow-y: scroll;
		}
		.container {
			margin: 0 auto;
			max-width: 750px;
			text-align: center;
		}
		.tt-dropdown-menu, .gist {
			text-align: left;
		}
		html {
			color: #333333;
			font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 18px;
			line-height: 1.2;
		}
		.title, .example-name {
			font-family: Prociono;
		}
		p {
			margin: 0 0 10px;
		}
		.title {
			font-size: 64px;
			margin: 20px 0 0;
		}
		.example {
			padding: 30px 0;
		}
		.example-name {
			font-size: 32px;
			margin: 20px 0;
		}
		.demo {
			margin: 50px 0;
			position: relative;
		}
		.typeahead, .tt-query, .tt-hint {
			border: 2px solid #CCCCCC;
			border-radius: 8px 8px 8px 8px;
			font-size: 24px;
			height: 30px;
			line-height: 30px;
			outline: medium none;
			padding: 8px 12px;
			width: 396px;
		}
		.typeahead {
			background-color: #FFFFFF;
		}
		.typeahead:focus {
			border: 2px solid #0097CF;
		}
		.tt-query {
			box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
		}
		.tt-hint {
			color: #999999;
		}
		.tt-dropdown-menu {
			background-color: #FFFFFF;
			border: 1px solid rgba(0, 0, 0, 0.2);
			border-radius: 8px 8px 8px 8px;
			box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
			margin-top: 12px;
			padding: 8px 0;
			width: 422px;
		}
		.tt-suggestion {
			font-size: 18px;
			line-height: 24px;
			padding: 3px 20px;
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
		.example-twitter-oss .tt-suggestion {
			padding: 8px 20px;
		}
		.example-twitter-oss .tt-suggestion + .tt-suggestion {
			border-top: 1px solid #CCCCCC;
		}
		.example-twitter-oss .repo-language {
			float: right;
			font-style: italic;
		}
		.example-twitter-oss .repo-name {
			font-weight: bold;
		}
		.example-twitter-oss .repo-description {
			font-size: 14px;
		}
		.example-sports .league-name {
			border-bottom: 1px solid #CCCCCC;
			margin: 0 20px 5px;
			padding: 3px 0;
		}
		.example-arabic .tt-dropdown-menu {
			text-align: right;
		}
	</style>
</head>

<body>
	{{ Form::open(array('route' => 'movies.search')) }}
	<input class="typeahead" placeholder="Movie Title Here" value="">
	<br>
	<input class="year" placeholder="Year Here" value="">
	<input class="id" placeholder="Year ID" value="">
	{{ Form::submit('go'); }}
	{{ Form::close() }}
</body>

</html>

<script>
	var movies = new Bloodhound({
		datumTokenizer: function (datum) {
			return Bloodhound.tokenizers.whitespace(datum.value);
		},
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: {
			url: 'http://api.themoviedb.org/3/search/movie?api_key=470fd2ec8853e25d2f8d86f685d2270e&query=%QUERY&search_type=ngram',
			filter: function (movies) {
			// Map the remote source JSON array to a JavaScript array
			return $.map(movies.results, function (movie) {
				return {
					id: movie.id,
					value: movie.original_title,
					year: (movie.release_date.substr(0, 4) ? movie.release_date.substr(0, 4) : '')
				};
			});
		}
	}
});

// Initialize the Bloodhound suggestion engine

movies.initialize();

// Instantiate the Typeahead UI
$('.typeahead').typeahead({
	hint: true,
	highlight: true
}, {
	displayKey: 'value',
	source: movies.ttAdapter(),
	templates: {
		empty: [
		'<div class="empty-message">',
		'unable to find any Best Picture winners that match the current query',
		'</div>'].join('\n'),
		suggestion: Handlebars.compile('<p><strong>@{{value}}</strong> – @{{year}}</p>')
	}

}).bind("typeahead:selected", function (obj, datum, name) {
	$('.year').val(datum.year);
	$('.id').val(datum.id);
});
</script>