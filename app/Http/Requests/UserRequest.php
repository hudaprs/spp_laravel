<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => request()->route('user') 
                ?  'required|max:255|email|unique:users,email,' . request()->route('user') 
                : 'required|max:255|email|unique:users,email',
            'password' => request()->route('user') 
                ? 'nullable'
                : 'required|max:255',
            'password_confirmation' => request()->route('user')
                ? 'nullable '
                : 'required|same:password',
            'role' => 'required'
        ];
    }
}
