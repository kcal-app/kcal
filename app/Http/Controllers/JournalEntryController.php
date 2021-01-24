<?php
/**
 * @noinspection PhpDocSignatureInspection
 */

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Rules\ArrayNotEmpty;
use App\Rules\InArray;
use App\Rules\StringIsDecimalOrFraction;
use App\Rules\UsesIngredientTrait;
use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class JournalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        return view('journal-entries.index')
            ->with('entries', JournalEntry::where([
                'user_id' => Auth::user()->id,
                'date' => $date,
            ])->get())
            ->with('date', Carbon::createFromFormat('Y-m-d', $date))
            ->with('nutrients', ['calories', 'fat', 'cholesterol', 'carbohydrates', 'sodium', 'protein']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ingredients = [];
        if ($old = old('ingredients')) {
            foreach ($old['amount'] as $key => $amount) {
                if (
                    empty($old['date'][$key])
                    && empty($old['meal'][$key])
                    && empty($amount)
                    && empty($old['unit'][$key])
                    && empty($old['id'][$key])
                ) {
                    continue;
                }
                $ingredients[] = [
                    'date' => $old['date'][$key],
                    'meal' => $old['meal'][$key],
                    'amount' => $amount,
                    'unit' => $old['unit'][$key],
                    'id' => $old['id'][$key],
                    'type' => $old['type'][$key],
                    'name' => $old['name'][$key],
                ];
            }
        }

        return view('journal-entries.create')
            ->with('ingredients', $ingredients)
            ->with('meals', JournalEntry::$meals)
            ->with('units', [
                ['value' => 'tsp', 'label' => 'tsp.'],
                ['value' => 'tbsp', 'label' => 'tbsp.'],
                ['value' => 'cup', 'label' => 'cup'],
                ['value' => 'oz', 'label' => 'oz'],
                ['value' => 'g', 'label' => 'grams'],
                ['value' => 'servings', 'label' => 'servings'],
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'ingredients.date' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.date.*' => ['nullable', 'date', 'required_with:ingredients.id.*'],
            'ingredients.meal' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.meal.*' => ['nullable', 'string', 'required_with:ingredients.id.*', new InArray(array_column(JournalEntry::$meals, 'value'))],
            'ingredients.amount' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.amount.*' => ['required_with:ingredients.id.*', 'nullable', new StringIsDecimalOrFraction],
            'ingredients.unit' => ['required', 'array'],
            'ingredients.unit.*' => ['nullable', 'string'],
            'ingredients.id' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.id.*' => 'required_with:ingredients.amount.*|nullable',
            'ingredients.type' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.type.*' => ['required_with:ingredients.id.*', 'nullable', new UsesIngredientTrait()],
        ]);

        $summary = [];
        $nutrients = array_fill_keys(Nutrients::$all, 0);

        // TODO: Improve efficiency? Potential for lots of queries here...
        foreach ($input['ingredients']['id'] as $key => $id) {
            if ($input['ingredients']['type'][$key] == Food::class) {
                $food = Food::whereId($id)->first();
                $nutrient_multiplier = Nutrients::calculateFoodNutrientMultiplier(
                    $food,
                    Number::floatFromString($input['ingredients']['amount'][$key]),
                    $input['ingredients']['unit'][$key],
                );
                foreach ($nutrients as $nutrient => $amount) {
                    $nutrients[$nutrient] += $food->{$nutrient} * $nutrient_multiplier;
                }
                $summary[] = "{$input['ingredients']['amount'][$key]} {$input['ingredients']['unit'][$key]} {$food->name}";
            }
            elseif ($input['ingredients']['type'][$key] == Recipe::class) {
                $recipe = Recipe::whereId($id)->first();
                foreach ($nutrients as $nutrient => $amount) {
                    $nutrients[$nutrient] += $recipe->{"{$nutrient}PerServing"}() * Number::floatFromString($input['ingredients']['amount'][$key]);
                }
                $summary[] = "{$input['ingredients']['amount'][$key]} {$input['ingredients']['unit'][$key]} {$recipe->name}";
            }
        }

        $entry = new JournalEntry([
            'summary' => implode(', ', $summary),
            'date' => $input['date'],
            'meal' => $input['meal'],
        ] + $nutrients);
        $entry->user()->associate(Auth::user());
        if ($entry->save()) {
            if (isset($foods)) {
                $entry->foods()->saveMany($foods);
            }
            if (isset($recipes)) {
                $entry->recipes()->saveMany($recipes);
            }
        }

        session()->flash('message', "Journal entry added!");
        return redirect()->route(
            'journal-entries.index',
            ['date' => $entry->date->format('Y-m-d')]
        );
    }

    /**
     * Confirm removal of the specified resource.
     */
    public function delete(JournalEntry $journalEntry): View
    {
        return view('journal-entries.delete')->with('entry', $journalEntry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JournalEntry $journalEntry): RedirectResponse
    {
        $journalEntry->delete();
        session()->flash('message', 'Journal entry deleted!');
        return redirect(route('journal-entries.index', [
            'date' => $journalEntry->date->toDateString()
        ]));
    }
}
