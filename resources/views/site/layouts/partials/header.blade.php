<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Plexy</title>

@if(App::environment() == 'production')
<link rel="stylesheet" href="{{secure_asset('assets/stylesheets/css/reset.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/stylesheets/css/normalize.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/stylesheets/css/select2.min.css')}}">
{{-- <link rel="stylesheet" href="{{secure_asset('assets/stylesheets/css/style.css')}}"> --}}
<script src="{{secure_asset('assets/js/modernizr.js')}}"></script>
@else
<link rel="stylesheet" href="{{asset('assets/stylesheets/css/reset.css')}}">
<link rel="stylesheet" href="{{asset('assets/stylesheets/css/normalize.css')}}">
<link rel="stylesheet" href="{{asset('assets/stylesheets/css/select2.min.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/stylesheets/css/style.css')}}"> --}}
<script src="{{asset('assets/js/modernizr.js')}}"></script>
@endif
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
@yield('styles')
