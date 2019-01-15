<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password'=> 'required',
            'username' => 'required|unique:users|min:5',
            //'role'=> 'required'
        ];
    }

    public function messages()
    {
        return [
            'role.required' => trans('msg.roleRequired')
        ];
    }
}
