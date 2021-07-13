<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'name' => 'min:2|max:30|string',
            'username' => 'min:2|max:20|string|unique:users,username,' . Auth::user()->id,
            'password' => 'min:8|max:50|string|nullable',
            'image' => 'image|nullable',
        ];
    }
}
