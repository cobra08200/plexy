<form class="search__form" method="POST" action="{{ URL::to('user') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
	<input class="search__input" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
	<input class="search__input" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{ Input::old('email') }}">
	<input class="search__input" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
	<input class="search__input" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
	<div class="search__request__full">
		<button class="btn" type="submit">Create New Account</button>
	</div>
</form>
<div class="search__request__full">
	<a href="/user/login"><button class="btn">(login)</button></a>
</div>
