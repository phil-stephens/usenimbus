<?php namespace Nimbus\Users;

use \Request;

trait TrackableTrait {

    public function save(array $options = array())
    {
        $request = Request::instance();

        $this->attributes['ip'] = $request->ip();
        $this->attributes['user_agent'] = $request->server('HTTP_USER_AGENT');

        parent::save($options);
    }

    public function setUpdatedAtAttribute($value)
    {
        return;
    }

}