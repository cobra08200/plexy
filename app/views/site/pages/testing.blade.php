@extends('admin.layouts.default')

@section('content')

<form name="cityselect">
    <select name="menu" onChange="window.document.location.href=this.options[this.selectedIndex].value;" value="GO">
        <option selected="selected">Select One</option>
        <option value="http://www.leeds.com">Leeds</option>
        <option value="http://www.manchester.com">Manchester</option>
    </select>
</form>

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">
			@if($user->hasRole("comment"))
			My
			@endif
			<!-- Tickets -->
		</h1>
	</div>
	<div id="no-more-tables">
		<table class="col-md-12 table-striped table-condensed table-hover cf">
			@if($user->hasRole("comment"))
			<thead class="cf">
				<tr>
					<th>User</th>
					<th>Status</th>
					<th>Topic</th>
					<th>Content</th>
					<th>Created</th>
				</tr>
			</thead>
			@endif
			@if($user->hasRole("admin"))
			<thead class="cf">
				<tr>
					<th>User</th>
					<th>
					<select class="form-control" id="status">
						<option>all statuses</option>
						<option>open</option>
						<option>pending</option>
						<option>closed</option>
					</select>
					</th>
					<th>
					<select class="form-control" id="topic">
						<option>all topics</option>
						<option>miscellaneous</option>
						<option>movies</option>
						<option>music</option>
						<option>tv</option>
					</select>
					</th>
					<th>Content</th>
					<th>Created</th>
				</tr>
			</thead>
			@endif
			<tbody>
				@foreach($issues as $issue)
				@if($issue->status === 'closed')
				<tr class="clickableRow" href="http://www.google.com/">
				@else
				<tr class="clickableRow" href="http://www.google.com/">
				@endif
					@if($user->hasRole("admin"))
					@endif
					<td data-title="User">{{ $issue->owner->username }}</td>
					<td data-title="Status">{{ $issue->status }}</td>
					<td data-title="Topic">{{ $issue->topic }}</td>
					<td data-title="Content">{{ $issue->content }}</td>
					<td data-title="Created">{{ $issue->created_at->diffForHumans() }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		{{ $issues->appends(Request::except('page'))->links() }}

	</div>


@if(!empty($search))
@else
<h1>empty query</h1>
		<?php
		$a = URL::to('/');
		$b = $a .'?status=open';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?status=pending';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?status=closed';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?topic=miscellaneous';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?topic=movies';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?topic=music';
		echo $b;
		?>
<br>
		<?php
		$b = $a .'?topic=tv';
		echo $b;
		?>
<br>

@endif


	<hr>

@if(isset($search['status']))

		@if($search['status'] === 'open')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
		@else
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=miscellaneous';
		}

		echo $b;
		?>
		@endif

		@if($search['status'] === 'pending')
		<h1>pending set</h1>
		@else
		@endif

		@if($search['status'] === 'closed')
		<h1>closed set</h1>
		@else
		@endif

@else

{{-- Status Not Set --}}
{{-- Status Not Set --}}
{{-- Status Not Set --}}
{{-- Status Not Set --}}

<h1>status else</h1>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'] . '?status=open';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=open';
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'] . '?status=open';
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'] . '?status=pending';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=pending';
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'] . '?status=pending';
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'] . '?status=closed';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=closed';
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'] . '?status=closed';
		}

		echo $b;
		?>

@endif

	<hr>


{{-- Topic Set --}}
{{-- Topic Set --}}
{{-- Topic Set --}}
{{-- Topic Set --}}

@if(isset($search['topic']))

<h1>topic set</h1>

		@if($search['topic'] === 'miscellaneous')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
		@else
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=miscellaneous';
		}

		echo $b;
		?>
		@endif
<br>
		@if($search['topic'] === 'movies')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
		@else
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=movies';
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=movies';
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=movies';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=movies';
		}

		echo $b;
		?>
		@endif
<br>
		@if($search['topic'] === 'music')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
		@else
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=music';
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=music';
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=music';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=music';
		}

		echo $b;
		?>
		@endif
<br>
		@if($search['topic'] === 'tv')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
		@else
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=tv';
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=tv';
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=tv';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=tv';
		}

		echo $b;
		?>
		@endif

@else

{{-- Topic Not Set --}}
{{-- Topic Not Set --}}
{{-- Topic Not Set --}}
{{-- Topic Not Set --}}

<h1>topic else</h1>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=miscellaneous';
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=miscellaneous';
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=movies';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=movies';
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=movies';
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=music';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=music';
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=music';
		}

		echo $b;
		?>
<br>
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=tv';
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=tv';
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=tv';
		}

		echo $b;
		?>
@endif

	<hr>

</div>

@stop

@section('scripts')
<script>
	jQuery(document).ready(function($) {
		$(".clickableRow").click(function() {
			window.document.location = $(this).attr("href");
		});
	});
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	var userselected = getParameterByName('user');
	var status = getParameterByName('status');
	var topic = getParameterByName('topic');
	// $(document).ready(function() {
	// 	$("#user option:contains(" + userselected + ")").prop("selected", true);
	// 	$("#status option:contains(" + status + ")").prop("selected", true);
	// 	$("#topic option:contains(" + topic + ")").prop("selected", true);
	// });
	// $(document).ready(function () {
	// 	$("#user").val(userselected);
	// 	$("#status").val(status);
	// 	$("#topic").val(topic);
	// });
</script>
@stop



@section('graveyard')
		<?php
		$a = URL::to('/');
		$b = '';

		if(isset($search['page']) && isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['status']))
		{
			$b = $a . '?page=' . $search['page'] . '?status=' . $search['status'];
		}

		elseif(isset($search['status']) && isset($search['topic']))
		{
			$b = $a . '?status=' . $search['status'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']) && isset($search['topic']))
		{
			$b = $a . '?page=' . $search['page'] . '?topic=' . $search['topic'];
		}

		elseif(isset($search['page']))
		{
			$b = $a . '?page=' . $search['page'];
		}

		elseif(isset($search['status']))
		{
			$b = $a . '?status=' . $search['status'];
		}

		elseif(isset($search['topic']))
		{
			$b = $a . '?topic=' . $search['topic'];
		}

		echo $b;
		?>
@stop