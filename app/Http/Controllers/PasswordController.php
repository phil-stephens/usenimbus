<?php namespace Nimbus\Http\Controllers;

use Nimbus\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Nimbus\Users\UserRepository;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;
    /**
     * @var UserRepository
     */
    private $userRepository;


	public function __construct(Guard $auth, PasswordBroker $passwords, UserRepository $userRepository)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;

		$this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    // Need to override this to not encrypt the password before saving
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function($user, $password)
        {
            $user->password = $password;

            $user->save();

            $this->userRepository->login($user);
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                flash()->success('Your password has been reset.');
                return redirect($this->redirectPath());

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

}
