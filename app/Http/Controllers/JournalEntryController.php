<?php
/**
 * @noinspection PhpDocSignatureInspection
 */

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Rules\ArrayNotEmpty;
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
        $foods = Food::all(['id', 'name', 'detail', 'brand'])
            ->sortBy('name')
            ->collect()
            ->map(function ($food) {
                return [
                    'value' => $food->id,
                    'label' => "{$food->name}"
                        . ($food->detail ? ", {$food->detail}" : "")
                        . ($food->brand ? " ({$food->brand})" : ""),
                ];
            });
        $recipes = Recipe::all(['id', 'name'])
            ->sortBy('name')
            ->collect()
            ->map(function ($recipe) {
                return ['value' => $recipe->id, 'label' => $recipe->name];
            });
        return view('journal-entries.create')
            ->with('foods', $foods)
            ->with('recipes', $recipes)
            ->with('meals', [
                ['value' => 'breakfast', 'label' => 'Breakfast'],
                ['value' => 'lunch', 'label' => 'Lunch'],
                ['value' => 'dinner', 'label' => 'Dinner'],
                ['value' => 'snacks', 'label' => 'Snacks'],
            ])
            ->with('units', [
                ['value' => 'tsp', 'label' => 'tsp.'],
                ['value' => 'tbsp', 'label' => 'tbsp.'],
                ['value' => 'cup', 'label' => 'cup'],
                ['value' => 'oz', 'label' => 'oz'],
                ['value' => 'servings', 'label' => 'servings'],
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'date' => 'required|date',
            'meal' => 'required|string',
            'amounts' => ['required', 'array', new ArrayNotEmpty],
            'amounts.*' => 'required_with:foods.*,recipes.*|nullable|numeric|min:0',
            'units' => ['required', 'array', new ArrayNotEmpty],
            'units.*' => 'nullable|string',
            'foods' => 'required|array',
            'foods.*' => 'nullable|exists:App\Models\Food,id',
            'recipes' => 'required|array',
            'recipes.*' => 'nullable|exists:App\Models\Recipe,id',
        ]);

        $summary = [];
        $nutrients = array_fill_keys(Nutrients::$list, 0);

        $foods_selected = array_filter($input['foods']);
        if (!empty($foods_selected)) {
            $foods = Food::findMany($foods_selected)->keyBy('id');
            foreach ($foods_selected as $key => $id) {
                $food = $foods->get($id);
                $nutrient_multiplier = Nutrients::calculateFoodNutrientMultiplier(
                    $food,
                    $input['amounts'][$key],
                    $input['units'][$key],
                );
                foreach ($nutrients as $nutrient => $amount) {
                    $nutrients[$nutrient] += $food->{$nutrient} * $nutrient_multiplier;
                }
                $summary[] = "{$input['amounts'][$key]} {$input['units'][$key]} {$food->name}";
            }
        }

        // TODO: Add support and/or error handling for non-servings.
        $recipes_selected = array_filter($input['recipes']);
        if (!empty($recipes_selected)) {
            $recipes = Recipe::findMany($recipes_selected)->keyBy('id');
            foreach ($recipes_selected as $key => $id) {
                $recipe = $recipes->get($id);
                foreach ($nutrients as $nutrient => $amount) {
                    $nutrients[$nutrient] += $recipe->{"{$nutrient}PerServing"}() * $input['amounts'][$key];
                }
                $summary[] = "{$input['amounts'][$key]} {$input['units'][$key]} {$recipe->name}";
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

        return back()->with('message', "Journal entry added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function show(JournalEntry $journalEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(JournalEntry $journalEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JournalEntry $journalEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(JournalEntry $journalEntry)
    {
        //
    }
}
