<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionsController extends Controller
{
    /**
     * Create a new sessions controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the login page.
     *
     * @return \Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Perform the login.
     *
     * @param  Request  $request
     * @return \Redirect
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username_or_email' => 'required',
            'password'          => 'required'
        ]);

        if ($this->verifyFriend($request) !== true) {
            return redirect()->back()
                             ->with('warning', "Could not verify friendship.");
        }

        if ($this->signIn($request)) {

            return redirect()->intended('/home')
                             ->with('info', "Welcome!");
        }

        return redirect()->back()
                         ->with('warning', "Could not sign you in.");
    }

    /**
     * Destroy the user's current session.
     *
     * @return \Redirect
     */
    public function logout()
    {
        Auth::logout();

        return redirect('login')
            ->with('info', "You have now been signed out. See ya.");
    }

    /**
     * Verify if request is an active friend or server owner.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function verifyFriend(Request $request)
    {
        $usernameOrEmail = $request->input('username_or_email');

        if (app('App\Http\Controllers\PlexController')->plexVerifyFriend($usernameOrEmail) !== false) {
            return true;
        }
    }

    /**
     * Attempt to sign in the user.
     *
     * @param  Request $request
     * @return boolean
     */
    protected function signIn(Request $request)
    {
        if (strpos($request->input('username_or_email'), '@') !== false && strpos($request->input('username_or_email'), '.') !== false) {
            return Auth::attempt($this->getCredentialsViaEmail($request), $request->has('remember'));
        } else {
            return Auth::attempt($this->getCredentialsViaName($request), $request->has('remember'));
        }
    }

    /**
     * Get the login credentials and requirements via email.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentialsViaEmail(Request $request)
    {
        return [
            'email'     => $request->input('username_or_email'),
            'password'  => $request->input('password'),
            'verified'  => true
        ];
    }

    /**
     * Get the login credentials and requirements via username.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentialsViaName(Request $request)
    {
        return [
            'name'      => $request->input('username_or_email'),
            'password'  => $request->input('password'),
            'verified'  => true
        ];
    }
}
