<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
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
        // @todo Handle meals update request.
        Auth::user()->refresh();
        session()->flash('message', "Meals customizations updated!");
        return redirect()->route('meals.edit');
    }

}
