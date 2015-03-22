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
				<h1><small class="pull-right">{{ $message->count() }} messages</small> Messages </h1>
			</div>
			<div class="comments-list">
				@foreach($message->all() as $messages)
				<div class="media">
					<p class="pull-right"><small>{{ $messages->created_at->diffForHumans() }}</small></p>
					<a class="media-left" href="#">
						<img src="http://placehold.it/40x40">
					</a>
					<div class="media-body">
						<?php
						$user = User::find($messages->user_id);
						?>

						<h4 class="media-heading user_name">{{ $user->username }}</h4>
						{{ $messages->body }}

					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<?php echo $message->links(); ?>

@stop
