@if (Request::path() === '/')
<form class="ui form" action="{{ route('search.submit') }}" id="report_submit" method="post">
  {!! csrf_field() !!}
  <input id="title" name="title" type="hidden" value="">
  <input id="year" name="year" type="hidden" value="">
  <input id="tmdb" name="tmdb" type="hidden" value="">
  <input id="poster" name="poster" type="hidden" value="">
  <input id="backdrop" name="backdrop" type="hidden" value="">
  <input id="topic" name="topic" type="hidden" value="">
  <input id="vote_average" name="vote_average" type="hidden" value="">
  <input id="type" name="type" type="hidden" value="issue">

  <div class="ui stackable grid">
    <div class="two wide column"></div>
    <div class="twelve wide column">
      <div class="ui basic segment">
        <div class="ui fluid category search report">
          <div class="ui left icon input">
            <input class="prompt" type="text" placeholder="Search...">
            <i class="search icon" id="report_search_icon"></i>
            <i class="green checkmark icon" id="report_checkmark_icon" style="display: none;"></i>
          </div>
        </div>
        <div class="ui hidden divider"></div>
        <div class="ui buttons report request">
          <button class="ui button" type="submit" name="type" value="issue">Report</button>
          <div class="or"></div>
          <button class="ui button" type="button" id="cancel_report" name="button">Cancel</button>
        </div>
      </div>
    </div>
    <div class="two wide column"></div>
  </div>

</form>
@endif
