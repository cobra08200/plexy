@if(Auth::check())
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Plexy</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
								<li{{ (Request::is('/') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('/') }}}">Home</a>
								</li>
						</ul>
						<ul class="nav navbar-nav pull-right">
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									{{{ Auth::user()->username }}}	<span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="{{{ URL::to('user/settings') }}}">Settings</a></li>
									<li class="divider"></li>
									<li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
								</ul>
							</li>
						</ul>
				</div>
				<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
</nav>
@else
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Plexy</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
								<li{{ (Request::is('/') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('/') }}}">Home</a>
								</li>
						</ul>
						<ul class="nav navbar-nav pull-right">
								@if (Auth::check())
								<li><a href="{{{ URL::to('user') }}}">Logged in as {{{ Auth::user()->username }}}</a></li>
								<li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
								@else
								<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">Login</a></li>
								<li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
								@endif
						</ul>
				</div>
				<!-- /.navbar-collapse -->
		</div>
		<!-- /.container -->
</nav>
@endif
