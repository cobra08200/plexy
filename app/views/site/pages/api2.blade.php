<html>
<head>
	<link href="assets/css/magicsuggest-min.css" rel="stylesheet">
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
	<script src="assets/js/magicsuggest-min.js"></script>
</head>

<body>
	{{ Form::open(array('route' => 'movies.search')) }}

	{{ Form::text('title', 'Title', array('id' => 'magicsuggest')) }}
	{{ Form::hidden('year', 'Year', array('id' => 'year')) }}
	{{ Form::hidden('movieid', 'MovieID', array('id' => 'movieid')) }}
	{{ Form::hidden('img', 'Image', array('id' => 'img')) }}
	{{ Form::submit('go'); }}

	{{ Form::close() }}

	<hr>

	<div id="magicsuggest"></div>
</body>

</html>

<script>
	$(function() {
		$('#magicsuggest').magicSuggest({
			data: 'http://api.themoviedb.org/3/search/movie?api_key=470fd2ec8853e25d2f8d86f685d2270e&query=%QUERY&include_adult=false&search_type=ngram'
		});
	});
</script>


<script>
	$('#ms-complex-templating').magicSuggest({
		data: 'random.json',
		renderer: function(data){
			return '<div style="padding: 5px; overflow:hidden;">' +
			'<div style="float: left;"><img src="' + data.picture + '" /></div>' +
			'<div style="float: left; margin-left: 5px">' +
			'<div style="font-weight: bold; color: #333; font-size: 10px; line-height: 11px">' + data.name + '</div>' +
			'<div style="color: #999; font-size: 9px">' + data.email + '</div>' +
			'</div>' +
			'</div><div style="clear:both;"></div>'; // make sure we have closed our dom stuff
		}
	});
</script>

</body>
</html>
