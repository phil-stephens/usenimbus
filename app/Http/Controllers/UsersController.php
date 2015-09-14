<?php namespace Nimbus\Http\Controllers;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Http\Requests\EditUserRequest;
use Nimbus\Users\UserRepository;
use \Auth;

class UsersController extends Controller {

    /**
     * @var UserRepository
     */
    private $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function edit()
    {
        return view('users.edit')->withClass('with-bottom-pane');;
    }

    public function update(EditUserRequest $request)
    {
        $this->userRepository->update(Auth::id(), $request->all());

        flash()->success('Your Details Have Been Updated');

        return redirect()->back();
    }

    public function destroy()
    {
        // Use Auth::id()
        if($this->userRepository->destroy(Auth::id()))
        {
            Auth::logout();

            flash()->success('Your account has been closed.');

            return redirect()->route('register_path');
        }
    }

}
