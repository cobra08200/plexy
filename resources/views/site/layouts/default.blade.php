<!DOCTYPE html>
<html>
<head>
	@include('site/layouts/partials/header')
</head>
<body>
	@include('site/layouts/partials/navigation')
	<div class="ui container">
		{{-- @include('loading') --}}
		@include('notifications')
		@yield('content')
		@include('site/layouts/partials/modalBasic')
		@include('site/layouts/partials/modal')
	</div>
	@include('site/layouts/partials/footer')
</body>
</html>
