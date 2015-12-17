@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <header id="title_big">PLEXY</header> --}}
{{-- semantic ui search --}}
<div class="ui center aligned basic segment" id="question">
  <div class="ui buttons report request">
    <button class="ui button" type="button" id="show_report"  name="button">Report</button>
    <div class="or"></div>
    <button class="ui button" type="button" id="show_request" name="button">Request</button>
  </div>
</div>

<div class="ui center aligned basic segment" id="report" style="display: none;">
  @include('site/layouts/partials/semantic_report_search')
</div>

<div class="ui center aligned basic segment" id="request" style="display: none;">
  @include('site/layouts/partials/semantic_request_search')
</div>

@if (count($tickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $tickets, 'header' => 'Tickets'])
@endif

@if (count($closedTickets) > 0)
@include('site/layouts/partials/issue_request_module', ['module' => $closedTickets, 'header' => 'Closed'])
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
    $("#question").hide();
  });
  $("#show_request").click(function(){
    $("#request").show();
    $("#request").insertBefore("#report");
    $("#report").hide();
    $("#question").hide();
  });
  $("#cancel_report").click(function(){
    $("#question").show();
    $("#report").hide();
    $("#request").hide();
  });
  $("#cancel_request").click(function(){
    $("#question").show();
    $("#report").hide();
    $("#request").hide();
  });
});

@if (count($tickets) > 0 || count($closedTickets) > 0)
$('.ui.modal')
  .modal('attach events', '.launch.modal', 'show')
;
@endif

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
                result_from   : 'plex_server',
              });
            }
            if (results.type == 'show') {
              response.results[type].results.push({
                id            : results.ratingKey,
                topic         : 'tv',
                title         : results.title,
                image         : results.thumb,
                description   : results.year,
                result_from   : 'plex_server',
              });
            }
            if (results.type == 'album') {
              response.results[type].results.push({
                id            : results.ratingKey,
                topic         : 'music',
                title         : results.title,
                image         : results.thumb,
                description   : results.year,
                result_from   : 'plex_server',
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
                result_from   : 'public',
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
                result_from   : 'public',
              });
            }
            if (results.type == 'album') {
              response.results[type].results.push({
                id            : results.id,
                topic         : 'music',
                title         : results.name,
                image         : results.images[0].url,
                description   : results.year,
                result_from   : 'public',
              });
            }
          }
        }
      });
      return response;
    },
    url: '{{ route('plex.server.search') }}?query={query}'
    // url: '{{ route('request.search.select2') }}?query={query}'
  },
  onSelect: function(result, response) {
    if (result.result_from == 'plex_server') {
      if (result.topic == 'movies') {
        console.log("plex movie");
        document.getElementById("title").value        = result.title ;
        document.getElementById("year").value         = result.description;
        document.getElementById("tmdb").value         = result.ratingKey;
        document.getElementById("poster").value       = result.image;
        // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
        document.getElementById("topic").value        = 'movies';
        document.getElementById("vote_average").value = result.rating;
      }
      if (result.topic == 'tv') {
        console.log("plex tv");
        document.getElementById("title").value        = result.title;
        document.getElementById("year").value         = result.description;
        document.getElementById("tmdb").value         = result.ratingKey;
        document.getElementById("poster").value       = result.image;
        // document.getElementById("backdrop").value  = 'https://image.tmdb.org/t/p/w780' + result.backdrop_path;
        document.getElementById("topic").value        = 'tv';
        document.getElementById("vote_average").value = result.rating;
      }
      if (result.topic == 'music') {
        console.log("plex music");
        document.getElementById("title").value        = result.title;
        document.getElementById("tmdb").value         = result.ratingKey;
        document.getElementById("poster").value       = result.image;
        document.getElementById("topic").value        = 'music';
      }
    } else {
      if (result.topic == 'movies') {
        console.log("public movie");
        document.getElementById("title").value        = result.title ;
        document.getElementById("year").value         = result.description;
        document.getElementById("tmdb").value         = result.id;
        document.getElementById("poster").value       = result.image;
        document.getElementById("backdrop").value     = result.backdrop_path;
        document.getElementById("topic").value        = result.type;
        document.getElementById("vote_average").value = result.vote_average;
      }
      if (result.topic == 'tv') {
        console.log("public tv");
        document.getElementById("title").value        = result.name;
        document.getElementById("year").value         = result.description;
        document.getElementById("tmdb").value         = result.id;
        document.getElementById("poster").value       = result.image;
        document.getElementById("backdrop").value     = result.backdrop_path;
        document.getElementById("topic").value        = result.type;
        document.getElementById("vote_average").value = result.vote_average;
      }
      if (result.topic == 'music') {
        console.log("public music");
        document.getElementById("title").value        = result.name;
        document.getElementById("tmdb").value         = result.id;
        document.getElementById("poster").value       = result.image;
        document.getElementById("topic").value        = 'music';
      }
    }
    // console.log(result ? result.title : 'null');
    // console.log(result)
    // return false;
  }
})

// @include('js/home/select2')

</script>

@stop
