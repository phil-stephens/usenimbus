<?php namespace Nimbus\Mailers;

use Nimbus\Users\User;
use Nimbus\Droplets\Droplet;

class DropletMailer extends Mailer {

    public function sendShareEmailsTo($emails, Droplet $droplet, User $user, $msg = null)
    {
        $subject = $user->name . ' would like to share some files with you';
        $view = 'emails.droplets.share';
        $data = compact('droplet', 'user', 'msg');

        foreach($emails as $email)
        {
            $this->sendTo(trim($email), $subject, $view, $data);
        }
    }
}