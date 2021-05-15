<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('goals.index')
            ->with('goals', Goal::whereUserId(Auth::user()->id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return $this->edit(new Goal());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateGoalRequest $request): RedirectResponse
    {
        return $this->update($request, new Goal());
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal): View
    {
        return view('goals.show')->with('goal', $goal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal): View
    {
        return view('goals.edit')->with('goal', $goal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoalRequest $request, Goal $goal): RedirectResponse
    {
        $attributes = $request->validated();
        if (isset($attributes['days'])) {
            $attributes['days'] = array_sum($attributes['days']);
        }
        $goal->fill($attributes)->user()->associate(Auth::user());
        $goal->save();
        session()->flash('message', "Goal updated!");
        return redirect()->route('goals.show', $goal);
    }

    /**
     * Confirm removal of specified resource.
     */
    public function delete(Goal $goal): View
    {
        return view('goals.delete')->with('goal', $goal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal): RedirectResponse
    {
        $goal->delete();
        return redirect(route('goals.index'))
            ->with('message', "Goal deleted!");
    }
}
