<?php namespace Nimbus\Http\Controllers;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Users\UserRepository;
use Nimbus\Http\Requests\LoginRequest;
use \Auth;

class SessionsController extends Controller {

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
        return view('sessions.create');
    }

    public function store(LoginRequest $request)
    {
        if( ! $this->userRepository->login( null, $request->only('email', 'password')) )
        {
            // Failed! Return to the login page
            flash()->error('We were unable to sign you in. Please check your credentials and try again.');

            return redirect()->back()->withInput();
        }

        return redirect()->intended('/');
    }

    public function destroy()
    {
        Auth::logout();

        flash()->message('You have now been logged out');

        return redirect()->route('login_path');
    }

}
