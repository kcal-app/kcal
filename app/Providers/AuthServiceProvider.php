<?php

namespace App\Providers;

use App\Models\Goal;
use App\Models\JournalDate;
use App\Models\JournalEntry;
use App\Models\User;
use App\Policies\GoalPolicy;
use App\Policies\JournalDatePolicy;
use App\Policies\JournalEntryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    protected $policies = [
        Goal::class => GoalPolicy::class,
        JournalDate::class => JournalDatePolicy::class,
        JournalEntry::class => JournalEntryPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
