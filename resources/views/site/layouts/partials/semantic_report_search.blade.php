@if (Request::path() === '/')
<form class="" action="{{ route('search.submit') }}" method="post">
  {!! csrf_field() !!}
  <input id="title" name="title" type="hidden" value="">
  <input id="year" name="year" type="hidden" value="">
  <input id="tmdb" name="tmdb" type="hidden" value="">
  <input id="poster" name="poster" type="hidden" value="">
  <input id="backdrop" name="backdrop" type="hidden" value="">
  <input id="topic" name="topic" type="hidden" value="">
  <input id="vote_average" name="vote_average" type="hidden" value="">

  <div class="ui search">
    <div class="ui left icon input">
      <input class="prompt" type="text" placeholder="Request Content">
      <i class="film icon"></i>
    </div>
  </div>

  <button class="ui button" type="submit" name="type" value="issue">Report</button>
</form>
@endif
