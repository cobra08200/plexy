<div class="container">
	<div class="omb_login">
		<h3 class="omb_authTitle">Login or {{ link_to('user/create', 'Sign up') }}</h3>
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">
				<form class="form-horizontal" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<fieldset>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input class="form-control" tabindex="1" placeholder="{{ Lang::get('confide::confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
						</div>
						<span class="help-block"></span>

						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
							<input type="password" class="form-control" tabindex="2" name="password" placeholder="{{ Lang::get('confide::confide.password') }}" id="password">
						</div>
						<span class="help-block"></span>
						<button tabindex="3"class="btn btn-lg btn-primary btn-block" type="submit">{{ Lang::get('confide::confide.login.submit') }}</button>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">
				<label for="remember" class="checkbox">
					<input type="hidden" name="remember" value="0">
				</label>
			</div>
			<div class="col-xs-12 col-sm-3">
				<p class="omb_forgotPwd">
					<a href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
				</p>
			</div>
		</div>
	</div>
</div>
