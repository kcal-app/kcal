<?php

namespace App\Http\Requests;

use App\Models\JournalEntry;
use App\Rules\ArrayNotEmpty;
use App\Rules\InArray;
use App\Rules\StringIsPositiveDecimalOrFraction;
use App\Rules\UsesIngredientTrait;
use Illuminate\Foundation\Http\FormRequest;

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
                'string',
                new InArray(JournalEntry::meals()->pluck('value')->toArray())
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
