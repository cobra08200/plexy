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

      // create new message
      $message = new Message;
      $message->user_id = Auth::id();
      $message->issue_id = Input::get('issue_id');
      $message->body = Input::get('body');

      $message->save();

      return Redirect::back();
    }
}
