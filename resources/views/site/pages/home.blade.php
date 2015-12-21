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

var $modalClose         = $('[data-modal-close]');
$modalContent           = $('[data-modal-content]');
$modalHeader            = $('[data-modal-header]');
$modalLoading           = $('[data-modal-loading]');
$modalBasicLoading      = $('[data-modal-basic-loading]');
$request_search_icon    = $('#request_search_icon');
$request_checkmark_icon = $('#request_checkmark_icon');
$report_search_icon     = $('#report_search_icon');
$report_checkmark_icon  = $('#report_checkmark_icon');

$(document)

.ajaxStart(function () {
  $modalLoading.show();
  $modalBasicLoading.show();
  $modalClose.hide();
  $modalContent.hide();
  $modalHeader.hide();
  $request_search_icon.show();
  $request_checkmark_icon.hide();
  $report_search_icon.show();
  $report_checkmark_icon.hide();
})

.ajaxStop(function () {
  $modalLoading.hide();
  $modalBasicLoading.hide();
  $modalClose.fadeIn();
  $modalContent.fadeIn();
  $modalHeader.fadeIn();
});

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

@if (count($tickets) > 0 || count($closedTickets) > 0)
$('.ui.modal')
  .modal('attach events', '.launch.modal', 'show')
;
@endif

@include('js/home/semantic/report')
@include('js/home/semantic/request')

var report_submit = $('#report_submit');

report_submit.submit(function (ev) {
  $modalBasic.html($noRemoveBasic).modal('show');
  $.ajax({
      type: report_submit.attr('method'),
      url: report_submit.attr('action'),
      data: report_submit.serialize(),
      success: function (data) {
          // $modalBasic.html(data).modal('show');
          $modalBasic.html(data).modal({ observeChanges:true }).modal('refresh');
      }
  });
  ev.preventDefault();
});

</script>

@stop
