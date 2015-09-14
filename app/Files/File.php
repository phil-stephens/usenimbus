<?php namespace Nimbus\Files;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use \Auth;

class File extends Model {

	use PresentableTrait;

    protected $presenter = 'Nimbus\Presenters\FilePresenter';

    protected $fillable = ['file_name', 'type', 'size', 'storage_id'];

    public function droplet()
    {
        return $this->belongsTo('Nimbus\Droplets\Droplet');
    }

    public function downloads()
    {
        return $this->hasMany('Nimbus\Files\Download');
    }

    public function storage()
    {
        return $this->belongsTo('Nimbus\Storages\Storage');
    }

    public function filesystem()
    {
        if( ! empty($this->storage_id)) return $this->storage->credentials;

        return env('DEFAULT_FILESYSTEM');
    }

    public function isImage()
    {
        if(in_array($this->type, ['image/jpg', 'image/jpeg', 'image/bmp', 'image/png', 'image/gif'])) return true;

        return false;
    }


    public function isDownloadable()
    {
        if($this->droplet->user_id == Auth::id()) return true;

        if( ! empty($this->droplet->limit) && $this->droplet->limit <= $this->downloads()->count()) return false;

        return true;
    }

}
