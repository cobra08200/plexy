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

@include('js/home/select2')

</script>

@stop
