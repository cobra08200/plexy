@extends('site.layouts.default')

@section('content')

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">
			{{ $issue->content }}
		</h1>
		<img src="{{ $issue->poster_url }}" width="200">
	</div>
</div>
{{ Form::open(array('route' => 'message.add')) }}
<div class="form-group">
{{ Form::textarea('body') }}
<input type="hidden" name="issue_id" value="{{ $issue->id }}">
{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
</div>
{{ Form::close() }}


<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="page-header">
				<h1><small class="pull-right"># of messages</small> Messages </h1>
			</div>
			<div class="comments-list">
				@foreach($message->all() as $messages)
				<div class="media">
					<p class="pull-right"><small>5 days ago</small></p>
					<a class="media-left" href="#">
						<img src="http://placehold.it/40x40">
					</a>
					<div class="media-body">

						<h4 class="media-heading user_name">Username</h4>
						{{ $messages->body }}

					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@stop
