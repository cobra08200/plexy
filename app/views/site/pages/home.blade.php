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
	{{ Form::hidden('movieid', '', array('id' => 'movieid')) }}
	{{ Form::hidden('img', '', array('id' => 'img')) }}
	{{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
	{{ Form::close() }}


	@foreach(array_chunk($issues->all(), 4) as $issue_row)
		<div class="row-fluid">
			@foreach ($issue_row as $issue)
				<img class="img-zoom" src="{{ $issue->poster_url }}" width="150">
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
	$( '#title' ).val(datum.value);
	$( '#year' ).val(datum.year);
	$( '#movieid' ).val(datum.movieid);
	$( '#img' ).val('http://image.tmdb.org/t/p/w500' + datum.poster_path);
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
