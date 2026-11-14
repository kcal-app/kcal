<?php

namespace App\Policies;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access (show, edit, delete) the entry.
     */
    public function access(User $user, JournalEntry $journalEntry): bool {
        return $user->id === $journalEntry->user_id;
    }

}
