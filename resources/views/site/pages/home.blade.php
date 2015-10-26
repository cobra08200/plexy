@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <header id="title_big">PLEXY</header> --}}

{{-- select2 --}}
<button type="button" id="show_report" name="button">Report</button>
<button type="button" id="show_request" name="button">Request</button>

<div id="report">
@include('site/layouts/partials/select2_report_search')
<button type="button" id="cancel_report" name="button">Cancel</button>
</div>
<div id="request">
@include('site/layouts/partials/select2_request_search')
<button type="button" id="cancel_request" name="button">Cancel</button>
</div>

@if(count($movie_requests) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $movie_requests, 'header' => 'MOVIE REQUESTS'])
@endif

@if(count($tv_requests) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $tv_requests, 'header' => 'TV REQUESTS'])
@endif

@if(count($music_requests) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $music_requests, 'header' => 'MUSIC REQUESTS'])
@endif

@if(count($movie_issues) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $movie_issues, 'header' => 'MOVIE ISSUES'])
@endif

@if(count($tv_issues) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $tv_issues, 'header' => 'TV ISSUES'])
@endif

@if(count($music_issues) > 0 )
    @include('site/layouts/partials/issue_request_module', ['module' => $music_issues, 'header' => 'MUSIC ISSUES'])
@endif

@if(count($closed) > 0)
    @include('site/layouts/partials/issue_request_module', ['module' => $closed, 'header' => 'CLOSED'])
	{{$closed->render()}}
@endif



@if(count($movie_requests) + count($movie_issues) + count($tv_requests) + count($tv_issues) + count($closed) == 0)
    {{-- ADD SOMETHING --}}
@endif

@stop

@section('scripts')

<script>

$("#report").hide();
$("#request").hide();
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
@include('js/home/select2')

</script>

@stop
