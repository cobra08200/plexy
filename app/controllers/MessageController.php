<?php

class MessageController extends BaseController
{

    /**
     * Message Model
     * @var Message
     */
    protected $message;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(Message $message)
    {
        parent::__construct();
        $this->message = $message;
    }

    public function messageAdd()
    {
      // inspect input
      // dd(Input::all());
    //   test
    //   $poster_url = Issue::find(Input::get('issue_id'))->poster_url;
    //   dd($poster_url);

      // create new message
      $message = new Message;
      $message->user_id = Auth::id();
      $message->issue_id = Input::get('issue_id');
      $message->body = Input::get('body');

      $message->save();

      //send email to opposite end of conversation

      //gather user info for the mailer
      $issue_id = Input::get('issue_id');
      $admin_email = User::find(1)->email;
      $admin_username = User::find(1)->username;
      $user_email = User::find(Input::get('user_id'))->email;
      $user_username = User::find(Input::get('user_id'))->username;
      $poster_url = Issue::find(Input::get('issue_id'))->poster_url;
      $title = Issue::find(Input::get('issue_id'))->content;
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

      return Redirect::back();
    }
}
