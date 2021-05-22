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
        // @todo Implement goal up behavior.
        return redirect()->route('journal-entries.show');
    }

}
