@extends('site.layouts.default')

@section('content')

<div class="row">

	<h1 class="page-header">
		{{ $issue->content }}
		<!-- <small>Secondary Text</small> -->
	</h1>

	<!-- Entries Column -->
	<div class="col-md-4">

		<img src="{{ $issue->poster_url }}" height="200" alt="">

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
								@if(Auth::user()->id === '1')
								{{ Form::open(array('url' => 'issues/update/' . $issue->id)) }}
									<select name="status" onchange="this.form.submit()">
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
								{{ Form::close() }}
								@else
									@if($issue->status === 'open')
									<span class="label label-primary">{{ ucwords($issue->status) }}</span>
									@elseif($issue->status === 'pending')
									<span class="label label-warning">{{ ucwords($issue->status) }}</span>
									@elseif($issue->status === 'closed')
									<span class="label label-default">{{ ucwords($issue->status) }}</span>
									@endif
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

{{-- Delete Button--}}

{{ Form::open(array('url' => 'issues/delete/' . $issue->id, 'class' => 'pull-right')) }}
{{ Form::hidden('_method', 'DELETE') }}
{{ Form::submit('Delete this issue', array('class' => 'btn btn-warning')) }}
{{ Form::close() }}

{{-- /Delete Button--}}

{{-- Messages--}}

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Comments</h1>
			<section class="comment-list">
				@foreach($messages as $messages)
				<?php $user = User::find($messages->user_id); ?>
				<article class="row">
					@if($messages->user_id > 1)
					<div class="col-md-2 col-sm-2 hidden-xs">
						<figure class="thumbnail">
						<img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
						<figcaption class="text-center">{{ $user->username }}</figcaption>
						</figure>
					</div>
					@endif
					<div class="col-md-10 col-sm-10">
						<div class="panel panel-default arrow left">
							<div class="panel-body">
								<header class="text-left">
								<div class="comment-user"><i class="fa fa-user"></i> {{ $user->username }}</div>
								<time class="comment-date"><i class="fa fa-clock-o"></i> {{ $messages->created_at->diffForHumans() }}</time>
								</header>
								<div class="comment-post">
								<p>{{ $messages->body }}</p>
								</div>
							</div>
						</div>
					</div>
					@if($messages->user_id == 1)
					<div class="col-md-2 col-sm-2 hidden-xs">
						<figure class="thumbnail">
						<img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
						<figcaption class="text-center">{{ $user->username }}</figcaption>
						</figure>
					</div>
					@endif
				</article>
				@endforeach
			</section>
		</div>
	</div>
</div>

{{-- Add Message --}}

{{ Form::open(array('route' => 'message.add')) }}
<div class="form-group">
	<textarea class="form-control" rows="3" name="body"></textarea>
	<input type="hidden" name="issue_id" value="{{ $issue->id }}">
	<input type="hidden" name="user_id" value="{{ $issue->user_id }}">
	{{ Form::submit('Submit', array('class' => 'btn btn-default')) }}
</div>
{{ Form::close() }}

{{-- /Add Message --}}

</div>

{{-- /Messages--}}

@stop
