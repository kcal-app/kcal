<?php

namespace App\Http\Requests;

use App\Models\JournalEntry;
use App\Rules\ArrayNotEmpty;
use App\Rules\InArray;
use App\Rules\StringIsPositiveDecimalOrFraction;
use App\Rules\UsesIngredientTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreJournalEntryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'ingredients.date' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.date.*' => ['nullable', 'date', 'required_with:ingredients.id.*'],
            'ingredients.meal' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.meal.*' => [
                'nullable',
                'string',
                'required_with:ingredients.id.*',
                new InArray(JournalEntry::meals()->pluck('value')->toArray())
            ],
            'ingredients.amount' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.amount.*' => ['required_with:ingredients.id.*', 'nullable', new StringIsPositiveDecimalOrFraction],
            'ingredients.unit' => ['required', 'array'],
            'ingredients.unit.*' => ['required_with:ingredients.id.*'],
            'ingredients.id.*' => 'required_with:ingredients.amount.*|nullable',
            'ingredients.type.*' => ['required_with:ingredients.id.*', 'nullable', new UsesIngredientTrait()],
            'group_entries' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes(): array
    {
        return [
            'ingredients.amount' => 'amount',
            'ingredients.amount.*' => 'amount',
            'ingredients.date' => 'date',
            'ingredients.date.*' => 'date',
            'ingredients.id.*' => 'item',
            'ingredients.meal' => 'meal',
            'ingredients.meal.*' => 'meal',
            'ingredients.unit' => 'unit',
            'ingredients.unit.*' => 'unit',
        ];
    }
}
