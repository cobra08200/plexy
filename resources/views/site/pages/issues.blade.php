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
		<div class="ui three steps">
			<div class="step">
		    <i class="info icon"></i>
		    <div class="content">
		      <div class="title">
						@if ($issue->type === 'issue')
						Report
						@else
						Request
						@endif
					</div>
		    </div>
		  </div>
			<div class="step">
		    <i class="wait icon"></i>
		    <div class="content">
					<div class="title">Added</div>
		      <div class="description">{{ ucwords($issue->created_at->diffForHumans()) }}</div>
		    </div>
		  </div>
		  <div class="step">
		    <i class="ticket icon"></i>
		    <div class="content">
					<div class="title">Status</div>
		      <div class="description">
						@if (Auth::user()->hasRole('admin'))
						<form class="" action="{{ route('update.issue', ['id' => $issue->id]) }}" method="post">
							{!! csrf_field() !!}
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
						{{ ucwords($issue->status) }}
						@endif
					</div>
		    </div>
		  </div>
		</div>

		@if ($issue->type === 'issue' && !empty($issue->report_option))
		@if (!empty($issue->tv_season_number) || !empty($issue->album_track_number))
		<div class="ui two steps">
		@else
		<div class="ui steps">
		@endif
		  <div class="step">
		    <i class="frown icon"></i>
		    <div class="content">
					<div class="title">Description</div>
		      <div class="description">{{ $issue->report_option}}</div>
		    </div>
		  </div>
			@if (!empty($issue->tv_season_number) || !empty($issue->album_track_number))
		  <div class="step">
		    <i class="remove icon"></i>
		    <div class="content">
					<div class="title">Details</div>
		      <div class="description">
						@if (!empty($issue->tv_season_number))
						Season {{ $issue->tv_season_number }}
						@if (!empty($issue->tv_episode_number))
						- Episode {{ $issue->tv_episode_number }}
						@endif
						@endif
						@if (!empty($issue->album_track_number))
						Track {{ $issue->album_track_number }}
						@endif
					</div>
		    </div>
		  </div>
			@endif
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

					{{-- @if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
					<div class="actions">
						<a class="reply edit_message">Edit</a>
						<form class="edit_message_input" action="{{ route('update.issue_description', ['id' => $issue->id]) }}" style="display: none;" method="post">
							{!! csrf_field() !!}
							<input type="text" name="issue_description" value="{{ $issue->issue_description }}">
							<button type="submit" name="button">Submit</button>
							<button type="button" name="button" class="cancel">Cancel</button>
						</form>
					</div>
					@endif --}}

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

					{{-- @if ($message['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
					<div class="actions">
						<a class="reply edit_message">Edit</a>
						<form class="edit_message_input" action="{{ route('update.message', ['id' => $issue->id, 'messageId' => $message->id]) }}" style="display: none;" method="post">
							{!! csrf_field() !!}
							<input type="text" name="message_body" value="{{ $message->body }}">
							<button type="submit" name="button">Submit</button>
							<button type="button" name="button" class="cancel">Cancel</button>
						</form>
					</div>
					@endif --}}

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

@if ($issue['user_id'] === Auth::id() || Auth::user()->hasRole('admin'))
<div class="actions">
	<form class="" action="{{ route('delete.issue', ['id' => $issue->id]) }}" method="post">
		{!! method_field('DELETE') !!}
		{!! csrf_field() !!}
		<button type="submit" class="ui secondary button">
			Delete This
		</button>
	</form>
</div>
@endif

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
