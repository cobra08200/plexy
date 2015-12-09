<!DOCTYPE html>
<html>
<head>
	@include('site/layouts/partials/header')
</head>
<body>
	@include('site/layouts/partials/navigation')
	<div class="ui container">
		@include('notifications')
		@yield('content')
		{{-- @include('loading') --}}
		{{-- @include('site/layouts/partials/modal') --}}
	</div>
	@include('site/layouts/partials/footer')
</body>
</html>
