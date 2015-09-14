<?php namespace Nimbus\Files;

use Nimbus\Droplets\Droplet;
use \Auth;

class FileRepository {

    public function getById($fileId, $dropletId)
    {
        return File::where('droplet_id', '=', $dropletId)->findOrFail($fileId);
    }

    public function getByPath($path)
    {
        $parts = explode('/', $path);

        $filename = $parts[1];
        $dropletSlug = $parts[0];

        $file = Droplet::where('slug', '=', $dropletSlug)
                        ->files()
                        ->where('file_name', '=', $filename)
                        ->with('storage')
                        ->firstOrFail();

        return $file;
    }

    public function create($dropletId, $storage_id, $file_name, $type, $size)
    {
        $file = new File(compact('storage_id', 'file_name', 'type', 'size'));

        Droplet::findOrFail($dropletId)
                    ->files()
                    ->save($file);

        return;
    }

    public function getPaginatedForDroplet($dropletId)
    {
        return Droplet::findOrFail($dropletId)
                    ->files()
                    ->with('droplet', 'downloads')
                    ->oldest()
                    ->paginate();
    }

    public function getForDownload($fileId, $dropletId)
    {
        $file = $this->getById($fileId, $dropletId);

        if($file->droplet->user_id != Auth::id())
        {
            $file->downloads()->save(
                new Download()
            );
        }

        return $file;
    }
}