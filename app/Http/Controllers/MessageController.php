<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Issue;
use App\User;
use App\Message;
use App\Mailers\AppMailer;
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
    public function messageAdd(Request $request, AppMailer $mailer)
    {
        $issue = Issue::find($request->input('issue_id'));

        // checker to see if they actually filled out a message
        $rules = array(
            'body'	=> 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            // redirect our user back to the form with the errors from the validator
            return redirect()->back()
            ->with('warning', "Woops.  You did something wrong.  Let's see if you can figure it out.");
        }
        // create new message
        $message = new Message;
        $message->user_id = Auth::id();
        $message->issue_id = $issue['id'];
        $message->body = $request->input('body');

        $message->save();

        if (env('APP_ENV') == 'production')
        {
            $comment = $message;
            // send email to opposite end of conversation
            // assume user 1 is the main admin account
            if (Auth::user()->id == 1)
            //email user the message from the admin
            {
                $user = User::find($request->input('user_id'));

                $mailer->sendNewMessageEmailTo($user, $issue, $comment);
            }
            else
            // email admin the message from the user
            {
                $user = User::find(1);

                $mailer->sendNewMessageEmailTo($user, $issue, $comment);
            }
        }

        return redirect()->back();
    }

    public function updateMessage($id, $messageId, Request $request)
    {
        $issue = Issue::find($id);
        $message = Message::find($messageId);

        if ($request->input('message_body') === $message->body)
        {
            return back()
                ->with('warning', "If you want to update the message you need to actually change it!");
        }

        $rules = array(
            'message_body'	=> 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return back()
                ->with('warning', "You need to write a message!");
        }

        $message->body = $request->input('message_body');
        $message->save();

        // Send update email eventually here

        return Redirect::to('issue/'.$id)
            ->with('info', "Successfully updated the message!");
    }

}
