<?php namespace Nimbus\Storages;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model {

	protected $fillable = ['credentials'];

    public function files()
    {
        return $this->hasMany('Nimbus\Files\File');
    }
}
