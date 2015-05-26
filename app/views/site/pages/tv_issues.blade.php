@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

<div class="row">
	<h2 class="page-header" align="center">
		{{ $issue->content }}
	</h2>
	<div class="col-md-4">
		<img src="{{ $issue->poster_url }}" height="200" alt="">
	</div>
	<div class="col-md-8">
		<div class="method">
			<div class="row margin-0">
				What episode is having issues?
				<input type="text" name="Season" placeholder="Season">
				<input type="text" name="Episode" placeholder="Episode">
			</div>
		</div>
	</div>
</div>

@stop
