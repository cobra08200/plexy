<html>
<head>
	<title>Title of the document</title>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	{{ HTML::style('css/magicsuggest-min.css') }}
	{{ HTML::script('magicsuggest-min.js') }}
</head>

{{Form::open(['route' => 'movies.search'])}}
<div class="col-md-6">
	<!-- To Form Input -->
	<div class="input-group form-group">
		{{ Form::label('to', 'To') }}
		{{ Form::text('recipients[]', null, array('class' => 'form-control','id' => 'ms')) }}
	</div>
</div>
{{Form::close()}}

</html>

<script>
$(function() {

    $('#ms').magicSuggest({
    	allowFreeEntries: false,
    	required: true,
        data: "/api/search/",
        valueField: 'id',
        displayField: 'username'
    });

});
</script>