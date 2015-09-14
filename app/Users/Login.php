<?php namespace Nimbus\Users;

use Illuminate\Database\Eloquent\Model;

class Login extends Model {

	use TrackableTrait;

    public function user()
    {
        return $this->belongsTo('Nimbus\Users\User');
    }

}
