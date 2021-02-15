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
use App\Support\ArrayFormat;
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
        $date = Carbon::rawCreateFromFormat('Y-m-d', $date);

        // Get entries and nutrient sums for the day.
        $entries = JournalEntry::where([
            'user_id' => Auth::user()->id,
            'date' => $date->toDateString(),
        ])->get();
        $sums = [];
        foreach (Nutrients::$all as $nutrient) {
            $sums[$nutrient['value']] = round($entries->sum($nutrient['value']));
        }

        // Get daily goals data for user.
        $goals = Auth::user()->getGoalsByTime($date);
        $dailyGoals = [];
        foreach (Nutrients::$all as $nutrient) {
            $goal = $goals['present']
                ->where('frequency', 'daily')
                ->where('name', $nutrient['value'])
                ->first();
            if ($goal) {
                $dailyGoals[$goal->name] = round($sums[$goal->name] / $goal->goal * 100);
                if ($dailyGoals[$goal->name] > 0) {
                    $dailyGoals[$goal->name] .= '%';
                }
            }
        }

        return view('journal-entries.index')
            ->with('entries', $entries)
            ->with('sums', $sums)
            ->with('dailyGoals', $dailyGoals)
            ->with('date', $date);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $date = $request->date ?? Carbon::now()->toDateString();
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
            ->with('units', Nutrients::$units)
            ->with('default_date', Carbon::createFromFormat('Y-m-d', $date));
    }

    /**
     * Show the form for creating a journal entry from nutrients directly.
     */
    public function createFromNutrients(Request $request): View
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        return view('journal-entries.create-from-nutrients')
            ->with('meals', JournalEntry::$meals)
            ->with('units', Nutrients::$units)
            ->with('default_date', Carbon::createFromFormat('Y-m-d', $date));
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
            'ingredients.unit.*' => ['required_with:ingredients.id.*'],
            'ingredients.id' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.id.*' => 'required_with:ingredients.amount.*|nullable',
            'ingredients.type' => ['required', 'array', new ArrayNotEmpty],
            'ingredients.type.*' => ['required_with:ingredients.id.*', 'nullable', new UsesIngredientTrait()],
        ]);

        $ingredients = ArrayFormat::flipTwoDimensionalKeys($input['ingredients']);

        /** @var \App\Models\JournalEntry[] $entries */
        $entries = [];
        // TODO: Improve efficiency? Potential for lots of queries here...
        foreach ($ingredients as $ingredient) {
            // Prepare entry values.
            $entry_key = "{$ingredient['date']}{$ingredient['meal']}";
            $entries[$entry_key] = $entries[$entry_key] ?? JournalEntry::make([
                'date' => $ingredient['date'],
                'meal' => $ingredient['meal'],
            ])->user()->associate(Auth::user());

            // Calculate amounts based on ingredient type.
            if ($ingredient['type'] == Food::class) {
                $item = Food::whereId($ingredient['id'])->first();
                $nutrient_multiplier = Nutrients::calculateFoodNutrientMultiplier(
                    $item,
                    Number::floatFromString($ingredient['amount']),
                    $ingredient['unit']
                );
                foreach (Nutrients::$all as $nutrient) {
                    $entries[$entry_key]->{$nutrient['value']} += $item->{$nutrient['value']} * $nutrient_multiplier;
                }
                $entries[$entry_key]->foods->add($item);
            }
            elseif ($ingredient['type'] == Recipe::class) {
                $item = Recipe::whereId($ingredient['id'])->first();
                foreach (Nutrients::$all as $nutrient) {
                    $entries[$entry_key]->{$nutrient['value']} += Nutrients::calculateRecipeNutrientAmount(
                        $item,
                        $nutrient['value'],
                        Number::floatFromString($ingredient['amount']),
                        $ingredient['unit']
                    );
                }
                $entries[$entry_key]->recipes->add($item);
            }
            else {
                return back()->withInput()->withErrors("Invalid ingredient type {$ingredient['type']}.");
            }

            // Update summary
            $unit = $ingredient['unit'];
            if ($item instanceof Food) {
                if (empty($item->serving_unit) && empty($item->serving_unit_name)) {
                    $unit = null;
                }
                elseif (!empty($item->serving_unit_name)) {
                    $unit = $item->serving_unit_formatted;
                }
            }
            $entries[$entry_key]->summary .= (!empty($entries[$entry_key]->summary) ? ', ' : null);
            $entries[$entry_key]->summary .= "{$ingredient['amount']} {$unit} {$item->name}";
        }

        foreach ($entries as $entry) {
            $entry->save();
            $entry->user->save();
            $entry->foods()->saveMany($entry->foods);
            $entry->recipes()->saveMany($entry->recipes);
        }

        $count = count($entries);
        session()->flash('message', "Added {$count} journal entries!");
        return redirect()->route('journal-entries.index');
    }

    /**
     * Store an entry from nutrients.
     */
    public function storeFromNutrients(Request $request): RedirectResponse {
        $attributes = $request->validate([
            'date' => ['required', 'date'],
            'meal' => ['required', 'string', new InArray(array_column(JournalEntry::$meals, 'value'))],
            'summary' => ['required', 'string'],
            'calories' => ['nullable', 'required_without_all:fat,cholesterol,sodium,carbohydrates,protein', 'numeric'],
            'fat' => ['nullable', 'required_without_all:calories,cholesterol,sodium,carbohydrates,protein', 'numeric'],
            'cholesterol' => ['nullable', 'required_without_all:calories,fat,sodium,carbohydrates,protein', 'numeric'],
            'sodium' => ['nullable', 'required_without_all:calories,fat,cholesterol,carbohydrates,protein', 'numeric'],
            'carbohydrates' => ['nullable', 'required_without_all:calories,fat,cholesterol,sodium,protein', 'numeric'],
            'protein' => ['nullable', 'required_without_all:calories,fat,cholesterol,sodium,carbohydrates', 'numeric'],
        ]);

        $entry = JournalEntry::make(array_filter($attributes))
            ->user()->associate(Auth::user());
        $entry->save();
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
