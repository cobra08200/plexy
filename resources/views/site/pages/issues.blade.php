@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<p>{{ $issue->content }}</p>

{{-- Admin's can force update the thumbnail in case the plex server had the wrong art at the time of being added --}}
@if (Auth::user()->hasRole('admin') && $issue->type === 'issue')
<a href="{{ route('update.plex.thumb.preview', ['ratingKey' => $issue->tmdb, 'thumbExtension' => $thumbExtension]) }}">
	<img src="{{ $issue->poster_url }}" width="200px" alt="Click to refresh thumbnail from Plex">
</a>
@else
<img src="{{ $issue->poster_url }}" width="200px" alt="{{ $issue->content }}">
@endif

@if (Auth::user()->hasRole('admin'))
<form class="" action="{{ route('update.issue', ['id' => $issue->id]) }}" method="post">
	{!! csrf_field() !!}
	Status:
	<select class="status_option" name="status" onchange="this.form.submit()">
		@if ($issue->status === 'open')
		<option selected="selected">{{ ucwords($issue->status) }}</option>
		<option>Pending</option>
		<option>Closed</option>
		@elseif ($issue->status === 'pending')
		<option>Open</option>
		<option selected="selected">{{ ucwords($issue->status) }}</option>
		<option>Closed</option>
		@elseif ($issue->status === 'closed')
		<option>Open</option>
		<option>Pending</option>
		<option selected="selected">{{ ucwords($issue->status) }}</option>
		@endif
	</select>
</form>
@else
<p>
	Status: {{ ucwords($issue->status) }}
</p>
@endif

<p>
	Added: {{ ucwords($issue->created_at->diffForHumans()) }}
</p>

@if ($issue->type === 'issue' && !empty($issue->report_option))
<p>
	Issue: {{ $issue->report_option}}
</p>
@endif

@if ($issue->type === 'issue' && !empty($issue->tv_season_number))
<div class="section group">
	<div class="col span_1_of_2">
		Season {{ $issue->tv_season_number }}
		@if (!empty($issue->tv_episode_number))
			- Episode {{ $issue->tv_episode_number }}
		@endif
	</div>
</div>
@endif

@if ($issue->type === 'issue' && !empty($issue->album_track_number))
<div class="section group">
	<div class="col span_1_of_2">
		Track: {{ $issue->album_track_number }}
	</div>
</div>
@endif

@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
{{-- Messages--}}
<p>Messages:</p>
@endif

@if (!empty($issue->issue_description))
<div class="view_message">
	{{ $issue->created_at->diffForHumans() }} by {{ $issue->user->name }}: {{ $issue->issue_description }}
	@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
		<button type="button" name="button" class="edit_message">Edit</button>
	</div>
	<form class="edit_message_input" action="{{ route('update.issue_description', ['id' => $issue->id]) }}" style="display: none;" method="post">
		{!! csrf_field() !!}
		<input type="text" name="issue_description" value="{{ $issue->issue_description }}">
		<button type="submit" name="button">Submit</button>
		<button type="button" name="button" class="cancel">Cancel</button>
	</form>
	@else
	</div>
	@endif
@endif

@if (!empty($messages))
	@foreach($messages as $message)
	<div class="view_message">
		{{ $message->created_at->diffForHumans() }} by {{ $message->user->name }}: {{ $message->body }}
		@if ($message['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
			<button type="button" name="button" class="edit_message">Edit</button>
		</div>
		<form class="edit_message_input" action="{{ route('update.message', ['id' => $issue->id, 'messageId' => $message->id]) }}" style="display: none;" method="post">
			{!! csrf_field() !!}
			<input type="text" name="message_body" value="{{ $message->body }}">
			<button type="submit" name="button">Submit</button>
			<button type="button" name="button" class="cancel">Cancel</button>
		</form>
		@else
		</div>
		@endif
	@endforeach
@endif

@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
{{-- Add Message --}}
<form class="" action="{{ route('message.add') }}" method="post">
	{!! csrf_field() !!}
	<textarea rows="3" name="body" placeholder="Type message here..."></textarea>
	<input type="hidden" name="issue_id" value="{{ $issue->id }}">
	<input type="hidden" name="user_id" value="{{ $issue->user_id }}">
	<br>
	<input type="submit" value="Submit">
</form>
{{-- /Add Message --}}

{{-- /Messages--}}

<hr>

<form class="" action="{{ route('delete.issue', ['id' => $issue->id]) }}" method="post">
	{!! method_field('DELETE') !!}
	{!! csrf_field() !!}
	<input type="submit" value="Delete This">
</form>
@endif

@stop

@section('scripts')

<script>

$(function() {
    $(".edit_message").on('click', function() {
        $(this).parent().toggle();
        $(this).parent().next(".edit_message_input").toggle();
    });
})

$(function() {
    $(".cancel").on('click', function() {
        $(this).parent().toggle();
        $(this).parent().prev(".view_message").toggle();
    });
})

</script>

@stop
