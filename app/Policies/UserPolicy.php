<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can administer (the application).
     */
    public function administer(User $user): bool {
        return $user->admin;
    }

    /**
     * Determine whether the user can edit a user via the "profile".
     */
    public function editProfile(User $user, User $model): bool {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->administer($user) && $user->id !== $model->id;
    }
}
