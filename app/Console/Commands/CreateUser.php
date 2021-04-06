<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * @inheritdoc
     */
    protected $signature = 'user:create
                            {email? : User email address}
                            {name? : User short name}
                            {password? : Account password}';

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
        if (!$arguments['email']) {
            $arguments['email'] = $this->ask('Enter an email address for the user');
        }

        // Validate email.
        $validator = Validator::make(['email' => $arguments['email']], [
            'email' => 'email',
        ]);
        if ($validator->fails()) {
            $this->error("Invalid email address {$arguments['email']}.");
            return 1;
        }

        // Check for an existing user.
        if (User::whereEmail($arguments['email'])->exists()) {
            $this->error("User with email address {$arguments['email']} already exists.");
            return 1;
        }

        if (!$arguments['name']) {
            $arguments['name'] = $this->ask('Enter a name for the user');
        }
        if (!$arguments['password']) {
            $arguments['password'] = $this->secret('Enter a password for the user');
            $password_confirm = $this->secret('Re-type the password to confirm');
            if ($arguments['password'] !== $password_confirm) {
                $this->error('Passwords did not match.');
                return 1;
            }
        }

        if (empty($arguments['email']) || empty($arguments['name']) || empty($arguments['password'])) {
            $this->error('All options (name, email, and password) are required.');
            return 1;
        }

        User::create([
            'name' => $arguments['name'],
            'email' => $arguments['email'],
            'password' => Hash::make($arguments['password']),
            'remember_token' => Str::random(10),
        ])->save();

        $this->info("User {$arguments['email']} created!");

        return 0;
    }
}
