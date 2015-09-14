<?php namespace Nimbus\Mailers;

use Nimbus\Users\User;

class UserMailer extends Mailer {

    public function sendWelcomeMessageTo(User $user, $password = null)
    {
        $subject = 'Welcome to Nimbus';
        $view = 'emails.registration.welcome';

        return $this->sendTo($user, $subject, $view, compact('user', 'password'));
    }

    public function sendGoodbyeMessageTo(User $user)
    {
        $subject = 'Your Nimbus account has been closed';
        $view = 'emails.registration.goodbye';

        return $this->sendTo($user, $subject, $view);
    }

    public function sendVerificationMessageTo($user)
    {
        $subject = 'Verify your email address';
        $view = 'emails.registration.verify';

        return $this->sendTo($user, $subject, $view, compact('user'));
    }
}