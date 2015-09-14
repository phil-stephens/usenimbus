<?php namespace Nimbus\Http\Controllers;

use Nimbus\Droplets\DropletRepository;
use Nimbus\Files\FileRepository;
use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Auth, \Crypt, \Session, \Validator;
use Nimbus\Http\Requests\DropletSecurityRequest;
use Carbon\Carbon;

class DropletsController extends Controller {

    /**
     * @var DropletRepository
     */
    private $dropletRepository;
    /**
     * @var FileRepository
     */
    private $fileRepository;

    function __construct(DropletRepository $dropletRepository, FileRepository $fileRepository)
    {
        $this->dropletRepository = $dropletRepository;
        $this->fileRepository = $fileRepository;
    }

    public function index()
    {
        if( ! Auth::user()->droplets->count() ) return $this->create();

        $droplets = $this->dropletRepository->getPaginatedForUser(Auth::id());

        return view('droplets.index', compact('droplets'));
    }

    public function show($slug)
    {
        // Get the droplet
        $droplet = $this->dropletRepository->getBySlug($slug);

        if($droplet->user_id != Auth::id())
        {
            $now = Carbon::now();
            // Is it valid? (start and finish dates)
            if(
                ( ! empty($droplet->start_at) && $droplet->start_at->gt($now) ) ||
                ( ! empty($droplet->finish_at) && $droplet->finish_at->lt($now) )
            )
            {
                die('Not active');
            }

            // Is it password protected - if so show the login page

            if(  ! empty($droplet->password) && ! in_array($droplet->id, session('droplets', [])))
            {
                return view('droplets.auth', compact('droplet'));
            }
        }

        $files = $this->fileRepository->getPaginatedForDroplet($droplet->id);

        return view('droplets.show', compact('droplet', 'files'));
    }

    public function handleAuth($slug, Request $request)
    {
        // Find the Droplet
        $droplet = $this->dropletRepository->getBySlug($slug);

        if($request->get('password') == Crypt::decrypt($droplet->password))
        {
            Session::push('droplets', $droplet->id);
        } else
        {
            flash()->error('Incorrect password');
        }

        return redirect()->back();
    }

    public function create()
    {
        $hash = md5( uniqid(Auth::id() . '.', true) );
        $class = 'with-bottom-pane';

        return view('droplets.create', compact('hash', 'class'));
    }

    public function created($uploadHash)
    {
        $droplet = $this->dropletRepository->getByHash($uploadHash);

        flash()->success('Droplet Created!');
        return redirect()->route('droplet_files_path', $droplet->id);
    }

    public function files($dropletId)
    {
        $droplet = $this->dropletRepository->getById($dropletId);
        $files = $this->fileRepository->getPaginatedForDroplet($dropletId);
        $class = 'with-top-pane';

        return view('droplets.files', compact('droplet', 'files', 'class'));
    }

    public function edit($dropletId)
    {
        $droplet = $this->dropletRepository->getById($dropletId);
        $class = 'with-top-pane with-bottom-pane';

        return view('droplets.edit', compact('droplet', 'class'));
    }

    public function update($dropletId, Request $request)
    {
        $formData = $request->all();

        if( ! isset($formData['watermark_images'])) $formData['watermark_images'] = false;

        $this->dropletRepository->update($dropletId, $formData);

        flash()->success('Droplet updated');
        return redirect()->back();
    }

    public function security($dropletId)
    {
        $droplet = $this->dropletRepository->getById($dropletId);
        $class = 'with-top-pane with-bottom-pane';

        return view('droplets.security', compact('droplet', 'class'));
    }

    public function updateSecurity($dropletId, DropletSecurityRequest $request)
    {
        // update the title...
        $this->dropletRepository->update($dropletId, $request->only('title'));

        // update the security settings...
        $this->dropletRepository->updateSecurity($dropletId, $request->all());

        flash()->success('Droplet updated');
        return redirect()->back();
    }

    public function share($dropletId)
    {
        $droplet = $this->dropletRepository->getById($dropletId);
        $class = 'with-top-pane with-bottom-pane';

        return view('droplets.share', compact('droplet', 'class'));
    }

    public function handleShare($dropletId, Request $request)
    {
        Validator::extend('emails', function($attribute, $value, $parameters)
        {
            $emails = explode(',', $value);

            foreach($emails as $email)
            {
                if( ! filter_var(trim($email), FILTER_VALIDATE_EMAIL))
                {
                    return FALSE;
                }
            }

            return TRUE;
        });

        // Validation
        $v = Validator::make($request->all(), [
            'emails' => 'required|emails',
        ]);

        if ($v->fails())
        {
            return redirect()->route('droplet_share_path', $dropletId)->withInput()->withErrors($v->errors());
        }

        // Still here?

        $count = $this->dropletRepository->sendShareEmails($dropletId, $request->all());

        $plural = str_plural('Email', $count);

        flash()->success("{$count} {$plural} sent");

        if($request->has('redirect')) return redirect()->to($request->get('redirect'));

        return redirect()->back();
    }

    public function destroy($dropletId)
    {

        if($this->dropletRepository->destroy($dropletId, Auth::id()))
        {
            flash()->success('Droplet deleted');
            return redirect()->route('droplets_path');
        }

        flash()->error('Unable to delete Droplet');
        return redirect()->back();

    }

}
