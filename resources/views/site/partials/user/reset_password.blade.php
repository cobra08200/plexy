<form class="search__form" method="POST" action="{{{ URL::to('user/reset') }}}" accept-charset="UTF-8">
    <input type="hidden" name="token" value="{{{ $token }}}">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <input class="search__input" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
    <input class="search__input" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
	<div class="search__request__full">
        <button type="submit" class="btn">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
	</div>
</form>
