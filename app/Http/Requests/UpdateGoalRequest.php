<?php

namespace App\Http\Requests;

use App\Rules\StringIsPositiveDecimalOrFraction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'frequency' => ['required', 'string'],
            'name' => ['required', 'string'],
            'goal' => ['required', 'numeric', 'min:0'],
        ];
    }

}
