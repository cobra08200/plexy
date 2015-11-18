<?php

namespace App\Http\Controllers;

use App\User;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /**
     * Create a new registration instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the register page.
     *
     * @return \Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Perform the registration.
     *
     * @param  Request   $request
     * @param  AppMailer $mailer
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'plex_username_or_email' => 'required|unique:users,name',
            'plex_username_or_email' => 'required|unique:users,email',
            'plex_password' => 'required'
        ]);

        $plexUsernameOrEmail = $request->input('plex_username_or_email');
        $plexPassword = $request->input('plex_password');

        // Authenticate the supplied credentials against Plex.
        $authenticationResponse = app('App\Http\Controllers\PlexController')->plexAuthorize($plexUsernameOrEmail, $plexPassword);

        // Deal with Plex authentication error before continuing.
        if (isset($authenticationResponse['error'])) {
            return redirect()->back()
                ->with('danger', $authenticationResponse['error']);
        }

        // Gather current friend list from Plex.
        $friendsResponse = app('App\Http\Controllers\PlexController')->plexFriends();

        // Check if the authenticated user is a friend of the server owner.
        foreach ($friendsResponse['User'] as $friend) {
            foreach ($friend['@attributes'] as $key => $value) {
                // If the authenticated user is a friend of the server owner, add them as a user with their Plex credentials.
                if ($key == 'email' && $value == $authenticationResponse['user']['email']) {
                    $user = new User;
                    $user->name     = $authenticationResponse['user']['username'];
                    $user->email    = $authenticationResponse['user']['email'];
                    $user->password = $plexPassword;
                    $user->save();
                }
            }
        }

        if (isset($user)) {
            $mailer->sendEmailConfirmationTo($user);

            return redirect()->back()
                ->with('info', "Please check your email confirm your account.");
        } else {
            return redirect()->back()
                ->with('danger', "Are you sure this Plex server is shared with you?");
        }
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        $tokenExists = User::where('token', $token)->first();

        if ($tokenExists)
        {
            $tokenExists->confirmEmail();
            return redirect('login')
                ->with('info', "You are now confirmed. Please login.");
        } else {
            return redirect('login');
        }
    }
}
