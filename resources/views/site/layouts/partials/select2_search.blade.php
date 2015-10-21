@if(Request::path() === '/')
{{-- <form class="" action="{{ route('search.submit') }}" method="post">
{!! csrf_field() !!}
<input id="title" name="title" type="hidden" value="">
<input id="year" name="year" type="hidden" value="">
<input id="tmdb" name="tmdb" type="hidden" value="">
<input id="poster" name="poster" type="hidden" value="">
<input id="backdrop" name="backdrop" type="hidden" value="">
<input id="topic" name="topic" type="hidden" value="">
<input id="vote_average" name="vote_average" type="hidden" value="">

<input placeholder="Search..." required="required" name="title" type="text" value="">

<button type="submit" name="type" value="request">Request</button>
<button type="submit" name="type" value="issue">Report</button>
</form> --}}

<select class="js-data-example-ajax" width="100%">
  <option selected="selected">Search...</option>
</select>
@endif
