<?php

namespace App\Policies;

use App\Models\JournalDate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalDatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access (view, modify) the journal date.
     */
    public function access(User $user, JournalDate $journalDate): bool {
        return $user->id === $journalDate->user_id;
    }

}
