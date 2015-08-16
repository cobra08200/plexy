<nav class="primary-nav">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<ul class="nav navbar-nav pull-right">
		@if (Auth::check())
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				{{{ Auth::user()->username }}}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li><a target="_blank" href="https://cash.me/$ehumps">Donate</a></li>
				<li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
			</ul>
		</li>
		@else
		<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">Login</a></li>
		<li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
		@endif
	</ul>
</nav>
