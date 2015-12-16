@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <header id="title_big">PLEXY</header> --}}
{{-- select2 --}}
<button type="button" id="show_report" name="button">Report</button>
<button type="button" id="show_request" name="button">Request</button>

<div id="report" style="display: none;">
  @include('site/layouts/partials/select2_report_search')
  <button type="button" id="cancel_report" name="button">Cancel</button>
</div>

<div id="request" style="display: none;">
  @include('site/layouts/partials/select2_request_search')
  <button type="button" id="cancel_request" name="button">Cancel</button>
</div>
{{-- semantic-ui search --}}

<div class="ui category search">
  <div class="ui left icon input">
    <input class="prompt" type="text" placeholder="Request Content">
    <i class="film icon"></i>
  </div>
</div>

@if (count($tickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $tickets, 'header' => 'TICKETS'])
@endif

@if (count($closedTickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $closedTickets, 'header' => 'CLOSED'])
{!! $closedTickets->render() !!}
@endif

@stop

@section('scripts')

<script>

var $modalClose = $('[data-modal-close]');
  $modalContent = $('[data-modal-content]');
  $modalLoading = $('[data-modal-loading]');
  $modalHeader  = $('[data-modal-header]');

$(document)

.ajaxStart(function () {
  $modalLoading.show();
  $modalClose.hide();
  $modalContent.hide();
  $modalHeader.hide();
})

.ajaxStop(function () {
  $modalLoading.hide();
  $modalClose.fadeIn();
  $modalContent.fadeIn();
  $modalHeader.fadeIn();
});

$(document).ready(function(){
  $("#show_report").click(function(){
    $("#report").show();
    $("#report").insertBefore("#request");
    $("#request").hide();
    $("#show_report").hide();
    $("#show_request").hide();
  });
  $("#show_request").click(function(){
    $("#request").show();
    $("#request").insertBefore("#report");
    $("#report").hide();
    $("#show_request").hide();
    $("#show_report").hide();
  });
  $("#cancel_report").click(function(){
    $("#show_report").show();
    $("#show_request").show();
    $("#report").hide();
    $("#request").hide();
  });
  $("#cancel_request").click(function(){
    $("#show_report").show();
    $("#show_request").show();
    $("#report").hide();
    $("#request").hide();
  });
});

$('.ui.modal')
  .modal('attach events', '.launch.modal', 'show')
;

// Request Search Semantic UI
$('.ui.search')
  .search({
    type          : 'category',
    minCharacters : 2,
    cache         : false,
    searchDelay   : 300,
    apiSettings   : {
      onResponse: function(requestResults) {
        var
          response = {
            results : {}
          }
        ;
        // translate API response to work with search
        $.each(requestResults.results, function(index, results) {
          var
            type = results.type || 'Unknown',
            maxResults = 12
          ;
          if (index >= maxResults) {
            return false;
          }
          if (results.thumb || results.poster_path || results.images ) {
            // create new category
            if (response.results[type] === undefined) {
              response.results[type] = {
                name    : type,
                results : []
              };
            }
            // add result to category
            if (results.results_from  == 'plex_server') {
              if (results.type == 'movie') {
                response.results[type].results.push({
                  id            : results.ratingKey,
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
              if (results.type == 'show') {
                response.results[type].results.push({
                  id            : results.ratingKey,
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
              if (results.type == 'album') {
                response.results[type].results.push({
                  id            : results.ratingKey,
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
            } else {
              if (results.type == 'movies') {
                response.results[type].results.push({
                  id            : results.id,
                  title         : results.title,
                  image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
                  description   : results.release_date.substr(0, 4),
                });
              }
              if (results.type == 'tv') {
                response.results[type].results.push({
                  id            : results.id,
                  title         : results.name,
                  image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
                  description   : results.first_air_date.substr(0, 4),
                });
              }
              if (results.type == 'album') {
                response.results[type].results.push({
                  id            : results.id,
                  title         : results.name,
                  image         : results.images[0].url,
                  description   : results.release_date.substr(0, 4),
                });
              }
            }
          }
        });
        return response;
      },
      // url: '{{ route('plex.server.search') }}?query={query}'
      url: '{{ route('request.search.select2') }}?query={query}'
    },
    onSelect: function(result, response) {
        // alert(result ? result.title : 'null');
    }
  })

@include('js/home/select2')

</script>

@stop
