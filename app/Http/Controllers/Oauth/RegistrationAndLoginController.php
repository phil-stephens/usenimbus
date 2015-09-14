<?php namespace Nimbus\Http\Controllers\Oauth;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Users\UserRepository;
use \Socialize, \Auth;

class RegistrationAndLoginController extends Controller {

    /**
     * @var UserRepository
     */
    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function redirectToProvider($provider)
    {
        return Socialize::with($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialize::with($provider)->user();

        return $this->authenticateOrRegister($user);
    }

    private function authenticateOrRegister($oauthUser)
    {
        if($user = $this->userRepository->getByEmail($oauthUser->getEmail()))
        {
            // User exists in the system...
            $this->userRepository->login($user);
        } else
        {
            // create a user
            $user = $this->userRepository->create([
                'name'  => $oauthUser->getName(),
                'email' => $oauthUser->getEmail()
            ]);

            $this->userRepository->login($user);

            flash()->message('Thank you for registering');
        }

        return redirect()->route('droplets_path');
    }
}
