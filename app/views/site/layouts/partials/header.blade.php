<meta charset="UTF-8">

<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>
	@section('title')
	Plexy
	@show
</title>

<meta name="keywords" content="@yield('keywords')" />
<meta name="author" content="@yield('author')" />
<!-- Google will often use this as its description of your page/site. Make it good. -->
<meta name="description" content="@yield('description')" />

<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
<meta name="google-site-verification" content="">

<!-- Dublin Core Metadata : http://dublincore.org/ -->
<meta name="DC.title" content="Plex Request">
<meta name="DC.subject" content="@yield('description')">
<meta name="DC.creator" content="@yield('author')">

<!--  Mobile Viewport Fix -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<!-- This is the traditional favicon.
- size: 16x16 or 32x32
- transparency is OK
- see wikipedia for info on browser support: http://mky.be/favicon/ -->
<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">

<!-- iOS favicons. -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

<!-- CSS -->
<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/prettify.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/wysihtml5/bootstrap-wysihtml5.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/datatables-bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/colorbox.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

@yield('styles')

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
