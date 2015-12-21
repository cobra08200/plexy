<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Plexy</title>

@if (env('APP_ENV') == 'production')
{{-- <link rel="stylesheet" href="{{ elixir('css/app.css') }}"> --}}
<link rel="stylesheet" href="{{secure_asset('assets/css/semantic.min.css')}}">
{{-- <link rel="stylesheet" href="{{secure_asset('assets/css/select2.css')}}"> --}}
<link rel="stylesheet" href="{{secure_asset('assets/css/custom.css')}}">
@else
{{-- <link rel="stylesheet" href="{{ elixir('css/app.css') }}"> --}}
<link rel="stylesheet" href="{{asset('assets/css/semantic.min.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/css/select2.css')}}"> --}}
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
@endif
@yield('styles')
