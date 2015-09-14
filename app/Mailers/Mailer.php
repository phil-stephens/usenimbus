<?php namespace Nimbus\Mailers;

use Illuminate\Mail\Mailer as Mail;

abstract class Mailer {

    /**
     * @var Mail
     */
    private $mail;

    function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function sendTo($user, $subject, $view, $data = [])
    {
        $this->mail->queue($view, $data, function ($message) use ($user, $subject)
        {
            $message->subject($subject);

            if (is_object($user))
            {
                $message->to($user->email, $user->name);
            } else
            {
                $message->to($user);
            }

        });

    }
}