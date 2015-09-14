<?php namespace Nimbus\Users;

use Nimbus\Mailers\UserMailer;
use \Auth;

class UserRepository {

    /**
     * @var UserMailer
     */
    private $userMailer;

    function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    public function getById($userId)
    {
        return User::findOrFail($userId);
    }

    public function getByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    public function login($user = null, $loginData = [])
    {
        if( ! empty($user))
        {
            $id = (is_object($user)) ? $user->id : $user;

            if( ! Auth::loginUsingId( $id ) )
            {
                return false;
            }
        } else
        {
            if( ! Auth::attempt( $loginData ) )
            {
                return false;
            }
        }

        Auth::user()->logins()->save(new Login);

        return true;
    }

    public function update($userId, $data)
    {
        $user = $this->getById($userId);

        if(empty($data['password']))
        {
            unset($data['password']);
        }

        $user->fill($data);

        $user->save();

        return true;
    }

    public function register(User $user, $sendEmail = true)
    {
        $user->save();

        // Send emails etc
        if($sendEmail)
        {
            if( ! $this->sendVerificationEmail($user)) $this->userMailer->sendWelcomeMessageTo($user);
        }

        return;
    }

    public function create($formData)
    {
        $password = ( ! empty( $formData['password'] )) ? $formData['password'] : str_random(8);

        $user = User::register(
            $formData['name'], $formData['email'], $password, true
        );

        $user->save();

        if( ! empty($formData['send_email']))
        {
            $this->userMailer->sendWelcomeMessageTo($user, $password);
        }

        return $user;
    }

    public function sendVerificationEmail($user)
    {
        if( ! $user->verified)
        {
            $this->userMailer->sendVerificationMessageTo($user);

            return true;
        }

        return false;
    }

    public function verify($verificationCode)
    {
        $user = User::where('verification_code', '=', $verificationCode)
            ->where('verified', '=', false)
            ->firstOrFail();

        $user->verified = true;

        $user->save();

        $this->userMailer->sendWelcomeMessageTo($user);

        return $user;
    }

    public function destroy($userId)
    {
        $user = $this->getById($userId);

        // Do file clean up

        $user->delete();

        return true;
    }


}