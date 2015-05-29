<div class="container">
    <div class="omb_login">
        <h3 class="omb_authTitle">Reset Password</h3>
        <div class="row omb_row-sm-offset-3">
            <div class="col-xs-12 col-sm-6">    
                <form method="POST" action="{{{ URL::to('user/reset') }}}" accept-charset="UTF-8">
                    <fieldset>
                        <input type="hidden" name="token" value="{{{ $token }}}">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <span class="help-block"></span>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
                        </div>
                        <span class="help-block"></span>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
                        </div>
                        <span class="help-block"></span>
                        <button type="submit" class="btn btn-lg btn-primary btn-block">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
