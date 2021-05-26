<?php

namespace App\Http\Requests;

use App\Rules\InArray;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFromNutrientsJournalEntryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'meal' => [
                'required',
                new InArray(Auth::user()->meals->pluck('value')->toArray())
            ],
            'summary' => ['required', 'string'],
            'calories' => ['nullable', 'numeric', 'min:0', 'required_without_all:fat,cholesterol,sodium,carbohydrates,protein'],
            'fat' => ['nullable', 'numeric', 'min:0', 'required_without_all:calories,cholesterol,sodium,carbohydrates,protein'],
            'cholesterol' => ['nullable', 'numeric', 'min:0', 'required_without_all:calories,fat,sodium,carbohydrates,protein'],
            'sodium' => ['nullable', 'numeric', 'min:0', 'required_without_all:calories,fat,cholesterol,carbohydrates,protein'],
            'carbohydrates' => ['nullable', 'numeric', 'min:0', 'required_without_all:calories,fat,cholesterol,sodium,protein'],
            'protein' => ['nullable', 'numeric', 'min:0', 'required_without_all:calories,fat,cholesterol,sodium,carbohydrates'],
        ];
    }
}
