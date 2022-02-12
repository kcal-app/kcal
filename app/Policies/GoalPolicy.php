<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access (show, edit, delete) the goal.
     */
    public function access(User $user, Goal $goal): bool {
        return $user->id === $goal->user_id;
    }

}
