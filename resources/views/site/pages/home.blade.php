@extends( Request::ajax() ? 'site.layouts.ajax' : 'site.layouts.default' )

@section('content')

{{-- <header id="title_big">PLEXY</header> --}}

{{-- @if(!$user->hasRole("admin")) --}}
{{-- typeahead --}}
{{-- @include('site/layouts/partials/typeahead_search') --}}
{{-- @endif --}}

{{-- select2 --}}
@include('site/layouts/partials/select2_search')

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

{{-- @include('js/home/typeahead') --}}
@include('js/home/select2')

</script>

@stop
