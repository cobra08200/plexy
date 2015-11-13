<!DOCTYPE html>
<html lang="en">
<head>
	@include('site/layouts/partials/header')
</head>
@if (Auth::check())
<body class="no-js {{ $bodyClass or null }}">
@else
<body class="login no-js">
@endif
{{-- <body> --}}
@include('site/layouts/partials/navigation')
@include('notifications')
@yield('content')
{{-- @include('site/layouts/partials/modal') --}}
@include('site/layouts/partials/footer')
</body>
</html>
