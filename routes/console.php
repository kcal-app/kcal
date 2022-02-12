<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

if (!App::isProduction()) {
    /**
     * Clear all caches.
     */
    Artisan::command('dev:cache-clear', function () {
        /** @phpstan-ignore-next-line */
        assert($this instanceof ClosureCommand);
        $commands = [
            'cache:clear',
            'config:clear',
            'route:clear',
            'view:clear',
        ];
        foreach ($commands as $command) {
            Artisan::call($command);
            $this->info(trim(Artisan::output()));
        }
        $this->info('All caches cleared!');
    })->purpose('Clear all caches.');

    /**
     * Wipe, migrate, and seed the database.
     */
    Artisan::command('dev:reset', function () {
        /** @phpstan-ignore-next-line */
        assert($this instanceof ClosureCommand);
        $commands = ['db:wipe', 'migrate', 'db:seed'];
        foreach ($commands as $command) {
            Artisan::call($command);
            $this->info(trim(Artisan::output()));
        }
        $this->info('Database reset complete!');
    })->purpose('Wipe, migrate, and seed the database.');
}
