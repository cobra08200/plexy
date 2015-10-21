<form class="search__form" method="POST" action="{{ URL::to('user/forgot-password') }}" accept-charset="UTF-8">
	<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <input class="search__input" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
	<div class="search__request__full">
        <button type="submit" class="btn">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
	</div>
</form>
<div class="search__request__full">
	<a href="/"><button class="btn">(home)</button></a>
</div>
