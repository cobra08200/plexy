<!DOCTYPE html>
<html>
<head>
	@include('site/layouts/partials/header')
</head>
<body>
	@include('site/layouts/partials/navigation')
	<div class="ui container">
		@include('site/layouts/partials/modal')
		@include('notifications')
		@yield('content')
		{{-- @include('loading') --}}
	</div>
	@include('site/layouts/partials/footer')
</body>
</html>
