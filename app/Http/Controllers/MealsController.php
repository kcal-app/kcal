<?php

namespace App\Http\Controllers;

use App\Rules\ArrayNotEmpty;
use App\Support\ArrayFormat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealsController extends Controller
{

    /**
     * Show the form for editing a user's meals data.
     */
    public function edit(): View
    {
        return view('meals.edit')->with('meals', Auth::user()->meals);
    }

    /**
     * Update the user profile data.
     */
    public function update(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'meal' => ['required', new ArrayNotEmpty],
            'meal.value.*' => ['required', 'numeric'],
            'meal.weight.*' => ['required', 'numeric'],
            'meal.label.*' => ['nullable', 'string'],
            'meal.enabled.*' => ['required', 'boolean'],
        ]);

        $user = Auth::user();
        $user->meals = ArrayFormat::flipTwoDimensionalKeys($attributes['meal']);
        $user->save();
        session()->flash('message', "Meals customizations updated!");
        return redirect()->route('meals.edit');
    }

}
