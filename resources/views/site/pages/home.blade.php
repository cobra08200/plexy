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
$loading = $('#loadingDiv');

$(document)

.ajaxStart(function () {
  $loading.toggle();
  $modalLoading.show();
  $modalClose.hide();
  $modalContent.hide();
  $modalHeader.hide();
})

.ajaxStop(function () {
  $loading.toggle();
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

@if (count($tickets) > 0 || count($closedTickets) > 0)
$('.ui.modal')
  .modal('attach events', '.launch.modal', 'show')
;
@endif

@include('js/home/semantic/report')

@include('js/home/semantic/request')

</script>

@stop
