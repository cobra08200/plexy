{{-- @extends('admin.layouts.default') --}}

@section('content')

<!-- <form name="cityselect">
    <select name="menu" onChange="window.document.location.href=this.options[this.selectedIndex].value;" value="GO">
        <option selected="selected">Select One</option>
        <option value="http://www.leeds.com">Leeds</option>
        <option value="http://www.manchester.com">Manchester</option>
    </select>
</form> -->

<div class="row">
	<div class="col-md-12">
		<h1 class="text-center">
		{{ $issue->content }}
		</h1>
		<!-- <img src="{{ $issue->poster_url }}"> -->
	</div>

@stop