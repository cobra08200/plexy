<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
						<button type="button" class="navbar-toggle"
							data-toggle="collapse"
							data-target="#account">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
						</button>
						<button type="button" class="navbar-toggle"
							data-toggle="collapse"
							data-target="#search">
								<span class="sr-only">Search</span>
								<span class="glyphicon glyphicon-search"></span>
						</button>
						<a class="navbar-brand" href="/">Plexy</a>
				</div>

				<!-- Search -->
				<div id="search" class="navbar_search collapse navbar-collapse">
					@include('site/layouts/partials/search')
				</div>

				<!-- Account login -->
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<!-- <ul class="nav navbar-nav">
								<li{{ (Request::is('/') ? ' class="active"' : '') }}>
										<a href="{{{ URL::to('/') }}}">Plexy</a>
								</li>
						</ul> -->
						<ul class="nav navbar-nav pull-right">
								@if (Auth::check())
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
										{{{ Auth::user()->username }}}
										<span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li><a href="{{{ URL::to('user/settings') }}}">Settings</a></li>
										<li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
									</ul>
								</li>
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
