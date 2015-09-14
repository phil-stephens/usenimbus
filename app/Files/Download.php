<?php namespace Nimbus\Files;

use Illuminate\Database\Eloquent\Model;
use Nimbus\Users\TrackableTrait;

class Download extends Model {

	use TrackableTrait;

    public function file()
    {
        return $this->belongsTo('Nimbus\Files\File');
    }

}
