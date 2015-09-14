<?php namespace Nimbus\Http\Controllers;

use Nimbus\Droplets\DropletRepository;
use Nimbus\Files\FileRepository;
use Nimbus\Http\Requests;
use Nimbus\Http\Controllers\Controller;

use Illuminate\Http\Request;
use \Auth, \Crypt;

class FilesController extends Controller {

    /**
     * @var FileRepository
     */
    private $fileRepository;
    /**
     * @var DropletRepository
     */
    private $dropletRepository;

    function __construct(FileRepository $fileRepository, DropletRepository $dropletRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->dropletRepository = $dropletRepository;
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        if($request->has('droplet_id'))
        {
            $droplet = $this->dropletRepository->getById($request->get('droplet_id'));
        } else
        {
            $droplet = $this->dropletRepository->getOrCreateByHash($request->get('upload_hash'), Auth::id());
        }

        if( $file = $request->file('file'))
        {
            $file_name = $file->getClientOriginalName();

            $filesystem = filesystem()->init($droplet->filesystem());

            try
            {
                // Does the source folder exist
                if( ! $filesystem->has($droplet->present()->directory))
                {
                    $filesystem->createDir($droplet->present()->directory);
                }

                $filesystem->write($droplet->present()->directory . '/' . $file_name, file_get_contents($file->getRealPath()));

                $this->fileRepository->create(
                  $droplet->id, $droplet->storage_id, $file_name, $file->getMimeType(), $file->getSize()
                );

                if ($request->ajax())
                {
                    return response()->json($droplet->id, 200);
                }

            } catch( \Exception $e)
            {
                die($e->getMessage());
            }

            return redirect()->back();
        }
    }

    public function download($crypt)
    {
        $details = json_decode( Crypt::decrypt($crypt) );
        $file = $this->fileRepository->getForDownload($details->file_id, $details->droplet_id);

        $filesystem = filesystem()->init($file->filesystem());

        if($filesystem->has($file->droplet->present()->directory . '/' . $file->file_name))
        {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Description: File Transfer');
            header("Content-type: {$file->type}");
            header("Content-Disposition: attachment; filename={$file->file_name}");
            header("Expires: 0");
            header("Pragma: public");

            echo $filesystem->read($file->droplet->present()->directory . '/' . $file->file_name);
        }
    }

    public function destroy($dropletId, $fileId)
    {
        $file = $this->fileRepository->getForDownload($fileId, $dropletId);

        if($file->droplet->user_id == Auth::id())
        {
            $file->delete();

            flash()->success('File deleted');
            return redirect()->back();
        }
    }

}
