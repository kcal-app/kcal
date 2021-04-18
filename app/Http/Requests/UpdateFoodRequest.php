<?php

namespace App\Http\Requests;

use App\Rules\StringIsPositiveDecimalOrFraction;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'detail' => ['nullable', 'string'],
            'brand' => ['nullable', 'string'],
            'source' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'serving_size' => ['required', new StringIsPositiveDecimalOrFraction],
            'serving_unit' => ['nullable', 'string'],
            'serving_unit_name' => ['nullable', 'string'],
            'serving_weight' => ['required', 'numeric', 'min:0'],
            'calories' => ['nullable', 'numeric', 'min:0'],
            'fat' => ['nullable', 'numeric', 'min:0'],
            'cholesterol' => ['nullable', 'numeric', 'min:0'],
            'sodium' => ['nullable', 'numeric', 'min:0'],
            'carbohydrates' => ['nullable', 'numeric', 'min:0'],
            'protein' => ['nullable', 'numeric', 'min:0'],
        ];
    }

}
