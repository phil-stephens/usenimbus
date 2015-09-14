<?php namespace Nimbus\Http\Controllers;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Users\UserRepository;
use Nimbus\Users\User;
use \Auth;
use Nimbus\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller {

    /**
     * @var UserRepository
     */
    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create()
    {
        return view('registration.create');
    }

    public function store(RegistrationRequest $request)
    {
        $user = User::register(
            $request->get('name'), $request->get('email'), $request->get('password'), $request->has('verified')
        );

        $this->userRepository->register($user);

        $this->userRepository->login($user);

        flash()->message('Thank you for registering');

        return ($user->verified) ? redirect()->route('droplets_path') : redirect()->route('unverified_path');
    }

    public function unverified()
    {
        if(Auth::user()->verified)
        {
            return redirect()->route('droplets_path');
        }

        return view('registration.unverified');
    }

    public function sendVerification()
    {
        if(Auth::user()->verified)
        {
            return redirect()->route('droplets_path');
        }

        if($this->userRepository->sendVerificationEmail(Auth::user()))
        {
            flash()->message('Verification email sent');
        }

        return redirect()->back();
    }

    public function verify($verificationCode)
    {
        if($user = $this->userRepository->verify($verificationCode))
        {
            $this->userRepository->login($user);

            flash()->message('Thank you for verifying your email address. Glad to have you as a new member!');

            return redirect()->route('droplets_path');
        }
    }

}
