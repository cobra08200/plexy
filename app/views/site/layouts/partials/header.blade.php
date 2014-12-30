<meta charset="utf-8" />
<title>
	@section('title')
	Laravel
	@show
</title>
@section('meta_keywords')
<meta name="keywords" content="your, awesome, keywords, here" />
@show
@section('meta_author')
<meta name="author" content="ehumps" />
@show
@section('meta_description')
<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />
@show

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

<style>
	body {
		padding: 60px 0;
	}
	@section('styles')
	@show
</style>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
