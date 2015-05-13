<!DOCTYPE html>
<html lang="en">
<head>
	@include('site/layouts/partials/header')
</head>

@if(Auth::check())
<body>
@else
<body>
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
	<!-- ./ container -->
	@include('site/layouts/partials/footer')
</body>
</html>
