<?php namespace Nimbus\Http\Controllers\Oauth;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Storages\StorageRepository;
use Nimbus\Storages\Oauth\Dropbox as DropboxOauth;
use Nimbus\Storages\Oauth\Copy as CopyOauth;
use \Session, \Auth;

class StorageController extends Controller {


    /**
     * @var StorageRepository
     */
    private $storageRepository;

    protected $testError;

    function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function dropbox(Request $request)
    {
        $provider = new DropboxOauth([
                                    'clientId'      => config('services.dropbox.clientId'),
                                    'clientSecret'  => config('services.dropbox.clientSecret'),
                                    'redirectUri'   => route('dropbox_oauth_path')
                                ]);

        if( ! $request->has('code'))
        {
            $authUrl = $provider->getAuthorizationUrl();

            Session::put('oauth2state', $provider->state);
            Session::save();

            return redirect($authUrl);
        } else if( ! $request->has('state') || $request->get('state') !== Session::get('oauth2state') )
        {
            Session::forget('oauth2state');
            die('Invalid state');
        } else
        {

            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);

            Session::forget('oauth2state');

            $credentials = filesystem()->store('dropbox', $token);

            return $this->testAndStoreCredentials($credentials);
        }


    }

    public function copy(Request $request)
    {
        $server = new CopyOauth([
            'identifier'    => config('services.copy.identifier'),
            'secret'        => config('services.copy.secret'),
            'callback_uri'  => route('copy_oauth_path')
        ]);

        if($request->has('oauth_token') && $request->has('oauth_verifier'))
        {
            $temporaryCredentials = Session::get('temporary_credentials');

            $token = $server->getTokenCredentials($temporaryCredentials, $request->get('oauth_token'), $request->get('oauth_verifier'));

            Session::forget('temporary_credentials');

            $credentials = filesystem()->store('copy', $token);

            return $this->testAndStoreCredentials($credentials);

            //$setup = filesystem()->initCopy(json_decode($credentials), '');
            //
            //$setup->createDir('nimbus');
            //
            //return $this->testAndStoreCredentials($credentials);
        }

        $temporaryCredentials = $server->getTemporaryCredentials();

        Session::put('temporary_credentials', $temporaryCredentials);
        Session::save();

        $server->authorize($temporaryCredentials);
    }

    private function testAndStoreCredentials($credentials)
    {
        $testing = filesystem()->init($credentials);

        try
        {
            $testing->listContents();

            // If that didn't break anything continue...
            $this->storageRepository->saveCredentials(Auth::id(), $credentials);

            flash()->success('Storage successfully added');

        } catch( \Exception $e)
        {
            $this->testError = $e->getMessage();

            flash()->error('There was a problem verifying the connection credentials');
        }

        return redirect()->route('storage_path');
    }

}
