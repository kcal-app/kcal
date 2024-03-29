<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', Rule::unique('users')->ignore($this->user)],
            'name' => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'admin' => ['nullable', 'boolean'],
            'image' => ['nullable', 'file', 'mimes:jpg,png,gif'],
            'remove_image' => ['nullable', 'boolean'],
        ];
        if (!$this->user) {
            $rules['password'] = ['required', 'string', 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string'];
        }
        return $rules;
    }

}
