<?php namespace Nimbus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Auth;

class EditUserRequest extends FormRequest {

    public function rules()
    {
        $id = Auth::id();

        return [
            'name'      => 'required',
            'email'     => "required|email|unique:users,email,{$id}",
            'password'  => 'min:6|confirmed'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
