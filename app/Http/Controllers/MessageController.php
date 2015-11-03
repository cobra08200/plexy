<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Issue;
use App\User;
use App\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
    * Processes a submitted message.
    *
    * @param  string  $request
    * @return Redirect
    */
    public function messageAdd(Request $request)
    {
        // checker to see if they actually filled out a message
        $rules = array(
            'body'	=> 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            // redirect our user back to the form with the errors from the validator
            return Redirect::back()
            ->with('warning', "Woops.  You did something wrong.  Let's see if you can figure it out.");
        }
        // create new message
        $message = new Message;
        $message->user_id = Auth::id();
        $message->issue_id = $request->input('issue_id');
        $message->body = $request->input('body');

        $message->save();

        if (\Config::get('app_env') == ('production'))
        {
            //send email to opposite end of conversation

            //gather user info for the mailer
            $issue_id = $request->input('issue_id');
            $admin_email = User::find(1)->email;
            $admin_username = User::find(1)->username;
            $user_email = User::find($request->input('user_id'))->email;
            $user_username = User::find($request->input('user_id'))->username;
            $poster_url = Issue::find($request->input('issue_id'))->poster_url;
            $title = Issue::find($request->input('issue_id'))->content;
            $comment = $message;

            $data = array(
                'issue_id'            => $issue_id,
                'admin_email'         => $admin_email,
                'admin_username'      => $admin_username,
                'user_email'          => $user_email,
                'user_username'       => $user_username,
                'poster_url'          => $poster_url,
                'title'               => $title,
                'comment'             => $message->body
            );

            if(Auth::user()->id == 1)
            //email user the message from the admin
            {
                Mail::later(5, 'emails.newmessage', $data, function($message) use ($issue_id, $user_email, $user_username, $comment, $poster_url, $title)
                {
                    $message->from('plexy@ehumps.me', 'Plexy');
                    $message->to($user_email, $user_username)->subject('Plexy - New Message - Ticket #'.$issue_id);
                });
            }
            else
            //email admin the message from the user
            {
                Mail::later(5, 'emails.newmessage', $data, function($message) use ($issue_id, $admin_email, $admin_username, $comment, $poster_url, $title)
                {
                    $message->from('plexy@ehumps.me', 'Plexy');
                    $message->to($admin_email, $admin_username)->subject('Plexy - New Message - Ticket #'.$issue_id);
                });
            }
        }

        return Redirect::back();
    }
}
