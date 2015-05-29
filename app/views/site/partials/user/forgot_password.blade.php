<div class="container">
    <div class="omb_login">
        <h3 class="omb_authTitle">Forgot Password</h3>
        <div class="row omb_row-sm-offset-3">
            <div class="col-xs-12 col-sm-6">    
                <form method="POST" action="{{ URL::to('user/forgot-password') }}" accept-charset="UTF-8">
                    <fieldset>
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <span class="help-block"></span>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                        </div>
                        <span class="help-block"></span>
                        <button type="submit" class="btn btn-lg btn-primary btn-block">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
