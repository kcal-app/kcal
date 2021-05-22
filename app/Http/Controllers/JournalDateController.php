<?php

namespace App\Http\Controllers;

use App\Models\JournalDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JournalDateController extends Controller
{

    /**
     * Change the goals for a journal date.
     */
    public function updateGoal(Request $request, JournalDate $journalDate): RedirectResponse
    {
        $attributes = $request->validate(['goal' => 'exists:App\Models\Goal,id']);
        $journalDate->goal()->associate($attributes['goal'])->save();
        return redirect()->route('journal-entries.index', [
            'date' => $journalDate->date->format('Y-m-d')
        ]);
    }

}
