<form class="search__form" method="POST" action="{{ URL::to('user/login') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input class="search__input" placeholder="{{ Lang::get('confide::confide.username_e_mail') }}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
	<input type="password" class="search__input" name="password" placeholder="{{ Lang::get('confide::confide.password') }}" id="password">
	<div class="search__request__full">
		<button class="btn" type="submit">{{ Lang::get('confide::confide.login.submit') }}</button>
	</div>
</form>
<div class="search__request">
	{{-- <a href="forgot"><button class="btn">{{ Lang::get('confide::confide.login.forgot_password') }}</button></a> --}}
	<a href="forgot"><button class="btn">(forgot)</button></a>
</div>
<div class="search__request">
	<a href="/user/create"><button class="btn">(signup)</button></a>
</div>
{{-- <label for="remember" class="checkbox">
	<input type="hidden" name="remember" value="0">
</label> --}}
