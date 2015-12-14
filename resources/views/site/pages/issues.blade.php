@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<i class="close icon"></i>
<div class="header">
	{{ $issue->content }}
</div>
<div class="image content">
	<div class="ui medium image">
		{{-- Admin's can force update the thumbnail in case the plex server had the wrong art at the time of being added --}}
		@if (Auth::user()->hasRole('admin') && $issue->type === 'issue')
		<a href="{{ route('update.plex.thumb.preview', ['ratingKey' => $issue->tmdb, 'thumbExtension' => $thumbExtension]) }}">
			<img src="{{ $issue->poster_url }}" alt="Click to refresh the thumbnail from Plex">
		</a>
		@else
		<img src="{{ $issue->poster_url }}" alt="{{ $issue->content }}">
		@endif
	</div>
	<div class="description">
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
		<div>
			<div
				Track: {{ $issue->album_track_number }}
			</div>
		</div>
		@endif

		@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))

		<div class="ui comments">
			<h3 class="ui dividing header">Messages</h3>

			@if (!empty($issue->issue_description))
			<div class="comment">
				<div class="content">
					<a class="author">{{ $issue->user->name }}</a>
					<div class="metadata">
						<span class="date">{{ $issue->created_at->diffForHumans() }}</span>
					</div>
					<div class="text">
						{{ $issue->issue_description }}
					</div>

					@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
					<div class="actions">
						<a class="reply edit_message">Edit</a>
						<form class="edit_message_input" action="{{ route('update.issue_description', ['id' => $issue->id]) }}" style="display: none;" method="post">
							{!! csrf_field() !!}
							<input type="text" name="issue_description" value="{{ $issue->issue_description }}">
							<button type="submit" name="button">Submit</button>
							<button type="button" name="button" class="cancel">Cancel</button>
						</form>
					</div>
					@endif

				</div>
			</div>
			@endif

			@if (!empty($messages))
			@foreach ($messages as $message)
			<div class="comment">
				<div class="content">

					<a class="author">{{ $message->user->name }}</a>

					<div class="metadata">
						<span class="date">{{ $message->created_at->diffForHumans() }}</span>
					</div>

					<div class="text">
						{{ $message->body }}
					</div>

					@if ($message['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
					<div class="actions">
						<a class="reply edit_message">Edit</a>
						<form class="edit_message_input" action="{{ route('update.message', ['id' => $issue->id, 'messageId' => $message->id]) }}" style="display: none;" method="post">
							{!! csrf_field() !!}
							<input type="text" name="message_body" value="{{ $message->body }}">
							<button type="submit" name="button">Submit</button>
							<button type="button" name="button" class="cancel">Cancel</button>
						</form>
					</div>
					@endif

				</div>
			</div>
			@endforeach
			@endif

			@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
			<form class="ui reply form" action="{{ route('message.add') }}" method="post">
				{!! csrf_field() !!}
				<div class="field">
					<textarea name="body" placeholder="Type message here..."></textarea>
				</div>
				<input type="hidden" name="issue_id" value="{{ $issue->id }}">
				<input type="hidden" name="user_id" value="{{ $issue->user_id }}">
				<button type="submit" class="ui blue labeled submit icon button">
					<i class="icon edit"></i> Add Reply
				</button>
			</form>
			@endif
		</div>
		@endif

	</div>
</div>

<div class="actions">
	<form class="" action="{{ route('delete.issue', ['id' => $issue->id]) }}" method="post">
		{!! method_field('DELETE') !!}
		{!! csrf_field() !!}
		<button type="submit" class="ui secondary button">
			Delete This
		</button>
	</form>
</div>

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
