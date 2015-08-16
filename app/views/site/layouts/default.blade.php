<!DOCTYPE html>
<html lang="en">
<head>
	@include('site/layouts/partials/header')
</head>

@if(Auth::check())
<body class="no-js {{ $bodyClass or null}}">
@else
<body class="page page--login no-js">
@endif
	<!-- Container -->
	<div class="container">
		@include('site/layouts/partials/navigation')

		<!-- Notifications -->
		@include('notifications')
		<!-- ./ notifications -->

		<!-- Content -->
		@yield('content')
		<!-- ./ content -->

		<!-- not sure what this is, prob can delete it -->
		<div id="push"></div>

	</div>

	{{-- plexy modal--}}
	@include('site/layouts/partials/modal')

	<!-- ./ container -->
	@include('site/layouts/partials/footer')

</body>
</html>
