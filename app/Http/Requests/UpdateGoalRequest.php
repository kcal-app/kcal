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
            'name' => ['required', 'string'],
            'days' => ['nullable', 'array'],
            'days.*' => ['nullable', 'numeric', 'min:0', 'max:64'],
            'calories' => ['nullable', 'numeric', 'min:0'],
            'fat' => ['nullable', 'numeric', 'min:0'],
            'cholesterol' => ['nullable', 'numeric', 'min:0'],
            'sodium' => ['nullable', 'numeric', 'min:0'],
            'carbohydrates' => ['nullable', 'numeric', 'min:0'],
            'protein' => ['nullable', 'numeric', 'min:0'],
        ];
    }

}
