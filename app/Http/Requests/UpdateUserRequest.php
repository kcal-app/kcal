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
            'name' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'confirmed'],
            'password_confirmation' => ['nullable', 'string'],
            'admin' => ['nullable', 'boolean'],
        ];
        if (!$this->user) {
            $rules['password'] = ['required', 'string', 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string'];
        }
        return $rules;
    }

}
