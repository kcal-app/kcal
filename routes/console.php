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
     * Wipe, migrate, and seed the database.
     */
    Artisan::command('dev:reset', function () {
        /** @phpstan-ignore-next-line */
        assert($this instanceof ClosureCommand);
        Artisan::call('db:wipe');
        $this->info(Artisan::output());
        Artisan::call('migrate');
        $this->info(Artisan::output());
        Artisan::call('db:seed');
        $this->info(Artisan::output());
        $this->info('Database reset complete!');
    })->purpose('Wipe, migrate, and seed the database.');
}
