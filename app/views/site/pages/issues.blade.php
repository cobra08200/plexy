@extends('site.layouts.default')

@section('content')

<div class="row">

	<h1 class="page-header">
		{{ $issue->content }}
		<!-- <small>Secondary Text</small> -->
	</h1>

	<!-- Entries Column -->
	<div class="col-md-4">

		<img class="img-responsive" src="{{ $issue->poster_url }}" width="100%" alt="">
		<hr>

	</div>

	<!-- Sidebar Widgets Column -->
	<div class="col-md-8">

		<div class="method">
			{{--
		        <div class="row margin-0 list-header hidden-sm hidden-xs">
		            <div class="col-md-3"><div class="header">Property</div></div>
		            <div class="col-md-2"><div class="header">Type</div></div>
		            <div class="col-md-2"><div class="header">Required</div></div>
		            <div class="col-md-5"><div class="header">Description</div></div>
		        </div>
			--}}

		        <div class="row margin-0">
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="propertyname">
		                        Status  <span class="mobile-isrequired"></span>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="type">
								@if($issue->status === 'open')
								<span class="label label-primary">{{ ucwords($issue->status) }}</span>
								@elseif($issue->status === 'pending')
								<span class="label label-warning">{{ ucwords($issue->status) }}</span>
								@elseif($issue->status === 'closed')
								<span class="label label-default">{{ ucwords($issue->status) }}</span>
								@endif
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="row margin-0">
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="propertyname">
		                        Type  <span class="mobile-isrequired"></span>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="type">
								<span class="label label-info">{{ ucwords($issue->type) }}</span>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="row margin-0">
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="propertyname">
		                        Plex URL  <span class="mobile-isrequired"></span>
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="type">
								@if($issue->plex_url != '')
								<a href="{{ ucwords($issue->plex_url) }}">Link</a>
								@else
								<span class="label label-danger">Not Available Yet</span>
								@endif
		                    </div>
		                </div>
		            </div>
		        </div>
		        <div class="row margin-0">
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="propertyname">
		                        Added
		                    </div>
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="cell">
		                    <div class="type">
		                        <code>{{ $issue->created_at->diffForHumans() }}</code>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>

		<!-- Side Widget Well -->
		<!-- <div class="well">
			<h4>Side Widget Well</h4>
		</div> -->

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
		@if(Auth::user()->id === 1)
		@foreach($message->all() as $messages)
		<?php
		$user = User::find($messages->user_id);
		?>
		<li>
			<div class="timeline-badge"><i class="glyphicon glyphicon-asterisk"></i></div>
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
		@foreach($message->all() as $messages)
		<?php
		$user = User::find($messages->user_id);
		?>
		<li class="timeline-inverted">
          <div class="timeline-badge"><i class="glyphicon glyphicon-user"></i></div>
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
		@endif

    </ul>
</div>

<?php echo $message->links(); ?>

@stop
