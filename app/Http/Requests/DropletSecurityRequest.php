<?php namespace Nimbus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class DropletSecurityRequest extends FormRequest {

    public function rules()
    {

        $rules = [];

        if($this->has('use_password')) $rules['password'] = 'required_without:password_set|min:6|confirmed';

        if($this->has('use_limit')) $rules['limit'] = 'required|numeric|min:1';

        if($this->has('use_expiry'))
        {
            $rules['start_at'] = 'required_without:finish_at';
            $rules['finish_at'] = 'required_without:start_at';
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
