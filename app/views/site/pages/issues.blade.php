@extends('site.layouts.default')

@section('content')

<!-- Portfolio Item Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">{{ $issue->content }}
			<!-- <small>Item Subheading</small> -->
		</h1>
	</div>
</div>
<!-- /.row -->

<!-- Portfolio Item Row -->
<div class="row">

	<div class="col-md-8">
		<img class="img-responsive" src="{{ $issue->poster_url }}" width="200" alt="{{ $issue->content }}">
	</div>

	<div class="col-md-4">
		<h3>Project Description</h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
		<h3>Project Details</h3>
		<ul>
			<li>Lorem Ipsum</li>
			<li>Dolor Sit Amet</li>
			<li>Consectetur</li>
			<li>Adipiscing Elit</li>
		</ul>
	</div>

</div>
<!-- /.row -->

<hr>

{{ Form::open(array('route' => 'message.add')) }}
<div class="form-group">
<textarea class="form-control" rows="3" name="body"></textarea>
<input type="hidden" name="issue_id" value="{{ $issue->id }}">
{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
</div>
{{ Form::close() }}

<div class="container">
    <div class="page-header">
        <h1 id="timeline">Messages</h1>
    </div>
    <ul class="timeline">
		@if(Auth::user()->id = 1)
		@foreach($message->all() as $messages)
		<?php
		$user = User::find($messages->user_id);
		?>
		<li>
			<div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">{{ $user->username }}</h4>
			<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $messages->created_at->diffForHumans() }}</small></p>
            </div>
            <div class="timeline-body">
              <p>{{ $messages->body }}</p>
            </div>
          </div>
        </li>
		@endforeach
		@else
		<?php
		$user = User::find($messages->user_id);
		?>
		<li class="timeline-inverted">
          <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
          <div class="timeline-panel">
            <div class="timeline-heading">
              <h4 class="timeline-title">{{ $user->username }}</h4>
              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{ $messages->created_at->diffForHumans() }}</small></p>
            </div>
            <div class="timeline-body">
				<p>{{ $messages->body }}</p>
            </div>
          </div>
        </li>
		@endif

    </ul>
</div>

<?php echo $message->links(); ?>

@stop
