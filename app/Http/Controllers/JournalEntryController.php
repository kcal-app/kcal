<?php
/**
 * @noinspection PhpDocSignatureInspection
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreFromNutrientsJournalEntryRequest;
use App\Http\Requests\StoreJournalEntryRequest;
use App\Models\Food;
use App\Models\JournalEntry;
use App\Models\Recipe;
use App\Support\ArrayFormat;
use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

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
        foreach (Nutrients::all()->pluck('value') as $nutrient) {
            $sums[$nutrient] = round($entries->sum($nutrient));
        }

        // Get daily goals data for user.
        $goals = Auth::user()->getGoalsByTime($date);
        $dailyGoals = [];
        foreach (Nutrients::all()->pluck('value') as $nutrient) {
            $goal = $goals['present']
                ->where('frequency', 'daily')
                ->where('name', $nutrient)
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
                $ingredients[$key] = [
                    'key' => $key,
                    'date' => $old['date'][$key],
                    'meal' => $old['meal'][$key],
                    'amount' => $amount,
                    'unit' => $old['unit'][$key],
                    'id' => $old['id'][$key],
                    'type' => $old['type'][$key],
                    'name' => $old['name'][$key],
                ];

                // Add supported units for the ingredient.
                $ingredient = NULL;
                if ($ingredients[$key]['type'] === Food::class) {
                    $ingredient = Food::whereId($ingredients[$key]['id'])->first();
                }
                elseif ($ingredients[$key]['type'] === Recipe::class) {
                    $ingredient = Recipe::whereId($ingredients[$key]['id'])->first();
                }
                if ($ingredient) {
                    $ingredients[$key]['units'] = $ingredient->units_supported;
                }
            }
        }

        return view('journal-entries.create')
            ->with('ingredients', $ingredients)
            ->with('meals', JournalEntry::meals()->toArray())
            ->with('units', Nutrients::units()->toArray())
            ->with('default_date', Carbon::createFromFormat('Y-m-d', $date));
    }

    /**
     * Show the form for creating a journal entry from nutrients directly.
     */
    public function createFromNutrients(Request $request): View
    {
        $date = $request->date ?? Carbon::now()->toDateString();
        return view('journal-entries.create-from-nutrients')
            ->with('meals', JournalEntry::meals()->toArray())
            ->with('units', Nutrients::units()->toArray())
            ->with('default_date', Carbon::createFromFormat('Y-m-d', $date));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJournalEntryRequest $request): RedirectResponse
    {
        $input = $request->validated();

        $ingredients = ArrayFormat::flipTwoDimensionalKeys($input['ingredients']);

        /** @var \App\Models\JournalEntry[] $entries */
        $entries = [];
        $entry_key = 0;
        $group_entries = isset($input['group_entries']) && (bool) $input['group_entries'];
        // TODO: Improve efficiency. Potential for lots of queries here...
        foreach ($ingredients as $ingredient) {
            // Set entry key (combined date and meal or individual entries).
            if ($group_entries) {
                $entry_key = "{$ingredient['date']}{$ingredient['meal']}";
            }
            else {
                $entry_key++;
            }

            // Get an existing entry (when grouping) or create a new one.
            $entries[$entry_key] = $entries[$entry_key] ?? JournalEntry::make([
                'date' => $ingredient['date'],
                'meal' => $ingredient['meal'],
            ])->user()->associate(Auth::user());
            $entry = &$entries[$entry_key];

            // Calculate amounts based on ingredient type.
            $item = NULL;
            $amount = Number::floatFromString($ingredient['amount']);
            if ($ingredient['type'] == Food::class) {
                $item = Food::whereId($ingredient['id'])->first();
                $nutrient_multiplier = Nutrients::calculateFoodNutrientMultiplier($item, $amount, $ingredient['unit']);
                foreach (Nutrients::all()->pluck('value') as $nutrient) {
                    $entry->{$nutrient} += $item->{$nutrient} * $nutrient_multiplier;
                }
                $entry->foods->add($item);
            }
            elseif ($ingredient['type'] == Recipe::class) {
                $item = Recipe::whereId($ingredient['id'])->first();
                foreach (Nutrients::all()->pluck('value') as $nutrient) {
                    $entry->{$nutrient} += Nutrients::calculateRecipeNutrientAmount($item, $nutrient, $amount, $ingredient['unit']);
                }
                $entry->recipes->add($item);
            }

            // Add to summary.
            if (!empty($entry->summary)) {
                $entry->summary .= '; ';
            }
            $entry->summary .= $this->createIngredientSummary($ingredient, $item, $amount);
        }

        // Save all new entries.
        foreach ($entries as $new_entry) {
            $new_entry->save();
            $new_entry->user->save();
            $new_entry->foods()->saveMany($new_entry->foods);
            $new_entry->recipes()->saveMany($new_entry->recipes);
        }

        $count = count($entries);
        session()->flash('message', "Added {$count} journal entries!");

        // Redirect to the date if only one date is used.
        $parameters = [];
        $unique_dates = array_unique($input['ingredients']['date']);
        if (count($unique_dates) === 1) {
            $parameters['date'] = reset($unique_dates);
        }
        return redirect()->route('journal-entries.index', $parameters);
    }

    /**
     * Attempt to create a coherent summary for an entry ingredient.
     */
    private function createIngredientSummary(array $ingredient, Food|Recipe $item, float $amount): string {
        $name = $item->name;
        $unit = $ingredient['unit'];

        // Determine unit with special handling for custom Food units.
        if ($item instanceof Food) {
            if ($unit === 'serving') {
                $no_serving_unit = empty($item->serving_unit) && empty($item->serving_unit_name);

                // If there is no serving unit or the serving unit name is
                // exactly the same as the item name don't use a serving
                // unit and pluralize the _item_ name.
                if ($no_serving_unit || $item->serving_unit_name === $name) {
                    $unit = null;
                    $name = Pluralizer::plural($name, $amount);
                }

                // If the serving unit name is already _part_ of the item
                // name, just keep the defined unit (e.g. name: "tortilla
                // chips" and serving name "chips").
                elseif (Str::contains($name, $item->serving_unit_name)) {
                    $unit = 'serving';
                }

                // If a serving unit name is set, use the formatted serving
                // unit name as a base.
                elseif (!empty($item->serving_unit_name)) {
                    $unit = $item->serving_unit_formatted;
                }
            }
        }

        // Pluralize unit with supplied plurals or Pluralizer.
        if (Nutrients::units()->has($unit)) {
            $value = 'label';
            if ($amount > 1) {
                $value = 'plural';
            }
            $unit = Nutrients::units()->get($unit)[$value];
        }
        else {
            $unit = Pluralizer::plural($unit, $amount);
        }

        // Add amount, unit, and name to summary.
        $amount = Number::rationalStringFromFloat($amount);
        $summary = "{$amount} {$unit} {$name}";

        // Add detail if available.
        if (isset($item->detail) && !empty($item->detail)) {
            $summary .= ", {$item->detail}";
        }

        return $summary;
    }

    /**
     * Store an entry from nutrients.
     */
    public function storeFromNutrients(StoreFromNutrientsJournalEntryRequest $request): RedirectResponse {
        $attributes = $request->validated();
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
    public function delete(JournalEntry $journal_entry): View
    {
        return view('journal-entries.delete')
            ->with('journal_entry', $journal_entry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JournalEntry $journal_entry): RedirectResponse
    {
        $journal_entry->delete();
        session()->flash('message', 'Journal entry deleted!');
        return redirect(route('journal-entries.index', [
            'date' => $journal_entry->date->toDateString()
        ]));
    }
}
