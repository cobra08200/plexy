@if(Auth::check())
<!DOCTYPE html>
<html lang="en">
<head>
	@include('site/layouts/partials/header')
</head>

<body>
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
@else
<!DOCTYPE html>
<html lang="en">
<head>
	@include('site/layouts/partials/header')
</head>

<body>
	<div id="wrap">
		@include('site/layouts/partials/navigation')

		<div class="container">
			@include('notifications')

			@yield('content')
		</div>

		<div id="push"></div>
	</div>

	@include('site/layouts/partials/footer')
</body>
</html>
@endif
