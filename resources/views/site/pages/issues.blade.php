@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<p>{{ $issue->content }}</p>
<img src="{{ $issue->poster_url }}" width="200px" alt="{{ $issue->content }}">

@if(Auth::user()->hasRole('admin'))
<form class="" action="{{ route('update.issue', ['id' => $issue->id]) }}" method="post">
	{!! csrf_field() !!}
	<select class="status_option" name="status" onchange="this.form.submit()">
		@if($issue->status === 'open')
		<option selected="selected">{{ ucwords($issue->status) }}</option>
		<option>Pending</option>
		<option>Closed</option>
		@elseif($issue->status === 'pending')
		<option>Open</option>
		<option selected="selected">{{ ucwords($issue->status) }}</option>
		<option>Closed</option>
		@elseif($issue->status === 'closed')
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

@if($issue->type === 'issue' && !empty($issue->report_option))
	<p>
		Issue: {{ $issue->report_option}}
	</p>
@endif

<form class="" action="{{ route('delete.issue', ['id' => $issue->id]) }}" method="post">
	{!! method_field('DELETE') !!}
	{!! csrf_field() !!}
	<input type="submit" value="Delete This">
</form>

{{-- @if($issue->topic == 'music')
<div class="section group">
	<div class="col span_1_of_2">
		Track Listing
	</div>
</div>
@endif --}}

{{-- Messages--}}
<div>Messages</div>

@if(!empty($issue->issue_description))
	<p>{{ $issue->created_at->diffForHumans() }} by {{ $issue->user->name }}</p>
	<p>{{ $issue->issue_description }}</p>
@endif

@if(count($messages) > 0)

@foreach($messages as $message)
	<p>{{ $message->created_at->diffForHumans() }} by {{ $message->user->name }}</p>
	<p>{{ $message->body }}</p>
@endforeach

@endif

{{-- Add Message --}}
<form class="" action="{{ route('message.add') }}" method="post">
	{!! csrf_field() !!}
	<textarea rows="3" name="body" placeholder="Type message here..."></textarea>
	<input type="hidden" name="issue_id" value="{{ $issue->id }}">
	<input type="hidden" name="user_id" value="{{ $issue->user_id }}">
	<input type="submit" value="Submit">
</form>
{{-- /Add Message --}}

{{-- /Messages--}}

@stop
