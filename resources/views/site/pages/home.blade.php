@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <header id="title_big">PLEXY</header> --}}
{{-- semantic ui search --}}
<button class="ui button" type="button" id="show_report" name="button">Report</button>
<button class="ui button" type="button" id="show_request" name="button">Request</button>

<div id="report" style="display: none;">
  @include('site/layouts/partials/semantic_report_search')
  <button class="ui button" type="button" id="cancel_report" name="button">Cancel</button>
</div>

<div id="request" style="display: none;">
  @include('site/layouts/partials/semantic_request_search')
  <button class="ui button" type="button" id="cancel_request" name="button">Cancel</button>
</div>

@if (count($tickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $tickets, 'header' => 'TICKETS'])
@endif

@if (count($closedTickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $closedTickets, 'header' => 'CLOSED'])
{!! $closedTickets->appends(Input::only('issues', 'requests'))->render() !!}
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
          if (results.thumb || results.poster_path || results.images) {
            // create new topic category
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
                  topic         : 'movies',
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
              if (results.type == 'show') {
                response.results[type].results.push({
                  id            : results.ratingKey,
                  topic         : 'tv',
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
              if (results.type == 'album') {
                response.results[type].results.push({
                  id            : results.ratingKey,
                  topic         : 'music',
                  title         : results.title,
                  image         : results.thumb,
                  description   : results.year,
                });
              }
            } else {
              if (results.type == 'movies') {
                response.results[type].results.push({
                  id            : results.id,
                  topic         : 'movies',
                  vote_average  : results.vote_average,
                  title         : results.title,
                  image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
                  backdrop_path : 'https://image.tmdb.org/t/p/w780' + results.backdrop_path,
                  description   : results.release_date.substr(0, 4),
                });
              }
              if (results.type == 'tv') {
                response.results[type].results.push({
                  id            : results.id,
                  topic         : 'tv',
                  vote_average  : results.vote_average,
                  title         : results.name,
                  image         : 'https://image.tmdb.org/t/p/w780' + results.poster_path,
                  backdrop_path : 'https://image.tmdb.org/t/p/w780' + results.backdrop_path,
                  description   : results.first_air_date.substr(0, 4),
                });
              }
              if (results.type == 'album') {
                response.results[type].results.push({
                  id            : results.id,
                  topic         : 'music',
                  title         : results.name,
                  image         : results.images[0].url,
                  description   : results.year,
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
      if (result.result_from == 'plex_server') {
          if (result.type == 'movie') {
              document.getElementById("title").value        = result.title ;
              document.getElementById("year").value         = result.year;
              document.getElementById("tmdb").value         = result.ratingKey;
              document.getElementById("poster").value       = result.thumb;
              // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
              document.getElementById("topic").value        = 'movies';
              document.getElementById("vote_average").value = result.rating;
          }
          if (result.type == 'show') {
              document.getElementById("title").value        = result.title;
              document.getElementById("year").value         = result.year;
              document.getElementById("tmdb").value         = result.ratingKey;
              document.getElementById("poster").value       = result.thumb;
              // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
              document.getElementById("topic").value        = 'tv';
              document.getElementById("vote_average").value = result.rating;
          }
          if (result.type == 'album') {
              document.getElementById("title").value        = result.title;
              document.getElementById("tmdb").value         = result.ratingKey;
              document.getElementById("poster").value       = result.thumb;
              document.getElementById("topic").value        = 'music';
          }
      } else {
          if (result.type == 'movies') {
              document.getElementById("title").value        = result.title ;
              document.getElementById("year").value         = result.release_date.substr(0, 4);
              document.getElementById("tmdb").value         = result.id;
              document.getElementById("poster").value       = 'https://image.tmdb.org/t/p/w780' + result.poster_path;
              document.getElementById("backdrop").value     = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
              document.getElementById("topic").value        = result.type;
              document.getElementById("vote_average").value = result.vote_average;
          }
          if (result.type == 'tv') {
              document.getElementById("title").value        = result.name;
              document.getElementById("year").value         = result.first_air_date.substr(0, 4);
              document.getElementById("tmdb").value         = result.id;
              document.getElementById("poster").value       = 'https://image.tmdb.org/t/p/w780' + result.poster_path;
              document.getElementById("backdrop").value     = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
              document.getElementById("topic").value        = result.type;
              document.getElementById("vote_average").value = result.vote_average;
          }
          if (result.type == 'album') {
              document.getElementById("title").value        = result.name;
              document.getElementById("tmdb").value         = result.id;
              document.getElementById("poster").value       = result.images[0].url;
              document.getElementById("topic").value        = 'music';
          }
      }
        // alert(result ? result.title : 'null');
        // console.log(result)
            // return false;

    }
  })

@include('js/home/select2')

</script>

@stop
