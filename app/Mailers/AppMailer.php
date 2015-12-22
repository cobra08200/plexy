<?php

namespace App\Mailers;

use App\User;
use App\Issue;
use App\Message;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{

    /**
     * The Laravel Mailer instance.
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * The sender of the email.
     *
     * @var string
     */
    protected $from = 'hello@ehumps.me';

    /**
     * The recipient of the email.
     *
     * @var string
     */
    protected $to;

    /**
     * The view for the email.
     *
     * @var string
     */
    protected $view;

    /**
     * The subject for the email.
     *
     * @var string
     */
    protected $subject;

    /**
     * The data associated with the view for the email.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new app mailer instance.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Deliver the email confirmation.
     *
     * @param  User $user
     * @return void
     */
    public function sendEmailConfirmationTo(User $user)
    {
        $this->to       = $user->email;
        $this->view     = 'emails.confirm';
        $this->data     = compact('user');
        $this->subject  = 'Plexy - Email Confirmation';

        $this->deliver();
    }

    /**
     * Deliver the newly requested confirmation.
     *
     * @param  User $user, Issue $issue
     * @return void
     */
    public function sendNewRequestEmailTo(User $user, $issue)
    {
        $this->to       = $user->email;
        $this->view     = 'emails.newRequest';
        $this->data     = compact('user', 'issue');
        $this->subject  = 'Plexy - Ticket #'.$issue['id'];

        $this->deliver();
    }

    /**
     * Deliver the message to the opposite end of the conversation.
     *
     * @param  User $user
     * @return void
     */
    public function sendNewMessageEmailTo(User $user, $from, $issue, $comment)
    {
        $this->to       = $user->email;
        $this->view     = 'emails.newMessage';
        $this->data     = compact('user', 'from', 'issue', 'comment');
        $this->subject  = 'Plexy - New Message - Ticket #'.$issue['id'];

        $this->deliver();
    }

    /**
     * Deliver the email.
     *
     * @return void
     */
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, 'Plexy')
                ->to($this->to)
                ->subject($this->subject);
        });
    }
}
