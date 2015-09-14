<?php namespace Nimbus\Glide;

use League\Glide\Server as Glide;
use League\Glide\Http\NotFoundException;
use Nimbus\Files\File;
use \DB;

class Server extends Glide {

    public function makeImage()
    {
        $request = $this->resolveRequestObject(func_get_args());

        if ($this->cacheFileExists($request) === true) {
            return $request;
        }

        // Set the source here...
        $parts = explode('/', $request->path);

        if(count($parts) > 2) array_shift($parts);

        $storage = DB::table('storages')
                            ->join('files', 'storages.id', '=', 'files.storage_id')
                            ->join('droplets', 'files.droplet_id', '=', 'droplets.id')
                            ->where('files.file_name', '=', $parts[1])
                            ->where('droplets.slug', '=', $parts[0])
                            ->select('storages.credentials')
                            ->first();

        if( ! empty($storage))
        {
            $this->setSource(filesystem()->init($storage->credentials));
        }

        //

        if ($this->sourceFileExists($request) === false) {
            throw new NotFoundException(
                'Could not find the image `'.$this->getSourcePath($request).'`.'
            );
        }

        $source = $this->source->read(
            $this->getSourcePath($request)
        );

        if ($source === false) {
            throw new FilesystemException(
                'Could not read the image `'.$this->getSourcePath($request).'`.'
            );
        }

        $tmp = tempnam( sys_get_temp_dir(), '');
        $handle = fopen($tmp, "w");
        fwrite($handle, $source);

        try {
            $write = $this->cache->write(
                $this->getCachePath($request),
                $this->api->run($request, $tmp)
            );
        } catch (FileExistsException $exception) {
            // Cache file failed to write. Fail silently.
            unlink($tmp);
            return $request;
        }

        unlink($tmp);

        if ($write === false) {
            throw new FilesystemException(
                'Could not write the image `'.$this->getCachePath($request).'`.'
            );
        }


        return $request;
    }
}