<?php

namespace Tests;

use App\Models\User;

trait LogsIn
{
    protected User $user;

    /**
     * Creates an admin and logs in.
     */
    public function loginAdmin(): void
    {
        $this->user = User::factory()
            ->admin()
            ->hasGoals(2)
            ->hasJournalEntries(5)
            ->create();
        $this->post('/login', [
            'username' => $this->user->username,
            'password' => 'password',
        ]);
    }

    /**
     * Creates a regular user and logs in.
     */
    public function loginUser(): void
    {
        $this->user = User::factory()
            ->hasGoals(2)
            ->hasJournalEntries(5)
            ->create(['admin' => false]);
        $this->post('/login', [
            'username' => $this->user->username,
            'password' => 'password',
        ]);
    }

    public function logout(): void {
        $this->post('/logout');
    }
}
