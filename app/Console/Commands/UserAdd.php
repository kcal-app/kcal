<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdd extends Command
{
    /**
     * @inheritdoc
     */
    protected $signature = 'user:add
                            {username? : Username}
                            {password? : Password}
                            {--name= : User short name};
                            {--admin : Makes the user an admin}';

    /**
     * @inheritdoc
     */
    protected $description = 'Create a new user.';

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a user, prompting for user information as needed.
     */
    public function handle(): int
    {
        $arguments = $this->arguments();
        if (!$arguments['username']) {
            $arguments['username'] = $this->ask('Enter a username for the user');
        }

        if (empty($arguments['username'])) {
            $this->error('Username is required.');
            return 1;
        }

        // Check for an existing user.
        if (User::whereUsername($arguments['username'])->exists()) {
            $this->error("User `{$arguments['username']}` already exists.");
            return 1;
        }

        $random_password = FALSE;
        if (!$arguments['password']) {
            $arguments['password'] = $this->secret('Enter a password for the user (leave blank for a random password)');
            if (!empty($arguments['password'])) {
                $password_confirm = $this->secret('Re-type the password to confirm');
                if ($arguments['password'] !== $password_confirm) {
                    $this->error('Passwords did not match.');
                    return 1;
                }
            }
        }
        if (empty($arguments['password'])) {
            $arguments['password'] = Str::random();
            $random_password = TRUE;
        }

        $options = $this->options();
        if (!$options['name']) {
            $options['name'] = $this->ask('Enter a name for the user', $arguments['username']);
        }

        User::create([
            'username' => $arguments['username'],
            'password' => Hash::make($arguments['password']),
            'name' => $options['name'] ?: $arguments['username'],
            'admin' => $options['admin'],
            'remember_token' => Str::random(10),
        ])->save();

        $this->info("User `{$arguments['username']}` added!");

        if ($random_password) {
            $this->info("Password: {$arguments['password']}");
        }

        return 0;
    }
}
