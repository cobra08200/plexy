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
