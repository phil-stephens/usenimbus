<?php namespace Nimbus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class StoreS3Request extends FormRequest {

    public function rules()
    {
        return [
            'key'       => 'required',
            'secret'    => 'required',
            'region'    => 'required',
            'bucket'    => 'required'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
