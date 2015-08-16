<div class="form-container">

	<h2 class="form__header visually-hidden">Login</h2>

	<form class="form" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<fieldset>

			<div class="form__group">
				<div class="form__group-cell">
					<label class="form__label" for="email">Email</label>
					<input class="form__control" tabindex="1" placeholder="{{ Lang::get('confide::confide.username_e_mail') }}" type="email" name="email" id="email" value="{{ Input::old('email') }}">
				</div>
			</div>

			<div class="form__group">
				<div class="form__group-cell">
					<label class="form__label" for="password">Password</label>
					<input  class="form__control" type="password" tabindex="2" name="password" placeholder="{{ Lang::get('confide::confide.password') }}" id="password">
					<button  class="form__control-toggle-button icon icon--show" type="button" data-toggle-password=""><span>show/hide password</span></button>
				</div>

				<div class="form__group-toggle">
					{{-- <input type="hidden" name="remember" value="0"> --}}
					<input type="checkbox" name="remember" value="1">
					<label class="input__option-note" for="remember" >
						Remember password?
					</label>
				</div>
			</div>

			<div class="form__action">
				<button tabindex="3" class="button button--large button--primary" type="submit">{{ Lang::get('confide::confide.login.submit') }}</button>
				<a class="button button--text button--small" href="forgot">{{ Lang::get('confide::confide.login.forgot_password') }}</a>
			</div>
		</fieldset>
	</form>

	{{ link_to('user/create', 'Sign up') }}

</div>
