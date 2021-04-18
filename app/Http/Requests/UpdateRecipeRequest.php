<?php

namespace App\Http\Requests;

use App\Rules\ArrayNotEmpty;
use App\Rules\StringIsPositiveDecimalOrFraction;
use App\Rules\UsesIngredientTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'description_delta' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'mimes:jpg,png,gif'],
            'remove_image' => ['nullable', 'boolean'],
            'servings' => ['required', 'numeric'],
            'time_prep' => ['nullable', 'numeric'],
            'time_cook' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'volume' => ['nullable', new StringIsPositiveDecimalOrFraction],
            'source' => ['nullable', 'string'],
            'ingredients.amount' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.amount.*' => ['required_with:ingredients.id.*', 'nullable', new StringIsPositiveDecimalOrFraction],
            'ingredients.unit' => ['required', 'array'],
            'ingredients.unit.*' => ['required_with:ingredients.id.*'],
            'ingredients.detail' => ['required', 'array'],
            'ingredients.detail.*' => ['nullable', 'string'],
            'ingredients.id' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.id.*' => ['required_with:ingredients.amount.*', 'required_with:ingredients.unit.*', 'nullable'],
            'ingredients.type' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.type.*' => ['required_with:ingredients.id.*', 'nullable', new UsesIngredientTrait()],
            'ingredients.key' => ['nullable', 'array'],
            'ingredients.key.*' => ['nullable', 'int'],
            'ingredients.weight' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.weight.*' => ['required', 'int'],
            'separators.key' => ['nullable', 'array'],
            'separators.key.*' => ['nullable', 'int'],
            'separators.weight' => ['nullable', 'array'],
            'separators.weight.*' => ['required', 'int'],
            'separators.text' => ['nullable', 'array'],
            'separators.text.*' => ['nullable', 'string'],
            'steps.step' => ['required', 'array', new ArrayNotEmpty],
            'steps.step.*' => ['nullable', 'string'],
            'steps.key' => ['nullable', 'array'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function messages(): array
    {
        return [
            'ingredients.id.*.required_with' => 'Missing :attribute in Ingredients.',
            'ingredients.amount.*.required_with' => 'Missing :attribute in Ingredients.',
            'ingredients.unit.*.required_with' => 'Missing :attribute in Ingredients.',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes(): array
    {
        return [
            'ingredients.id.*' => 'ingredient name',
            'ingredients.amount.*' => 'ingredient amount',
            'ingredients.unit.*' => 'ingredient unit',
        ];
    }

}
