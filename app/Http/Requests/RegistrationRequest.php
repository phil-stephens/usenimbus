<?php namespace Nimbus\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest {

    public function rules()
    {
        return [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed'
        ];
    }

    public function authorize()
    {
        return true;
    }
}