<?php namespace Nimbus\Http\Controllers;

use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Nimbus\Http\Requests\StoreS3Request;
use Nimbus\Storages\StorageRepository;
use \Auth;

class StoragesController extends Controller {

    /**
     * @var StorageRepository
     */
    private $storageRepository;

    function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function index()
    {
        if( ! Auth::user()->storage()) return $this->create();

        $storage = Auth::user()->storage();
        $credentials = json_decode( Auth::user()->storage('credentials') );
        $class = 'with-bottom-pane';

        return view('storages.index', compact('storage', 'credentials', 'class'));
    }

    public function create()
    {
        return view('storages.create');
    }

    public function s3()
    {
        return view('storages.s3')->withClass('with-bottom-pane');
    }

    public function handleS3(StoreS3Request $request)
    {
        $credentials = filesystem()->store('s3', $request->all());

        if($this->storageRepository->testAndStoreCredentials(Auth::id(), $credentials))
        {
            flash()->success('Storage successfully added');
        } else
        {
            flash()->error('There was a problem verifying the connection credentials');
        }

        return redirect()->route('storage_path');
    }

    public function destroy($storageId)
    {
        $this->storageRepository->destroy($storageId, Auth::id());

        flash()->success('Storage provider removed');

        return redirect()->back();
    }

}
