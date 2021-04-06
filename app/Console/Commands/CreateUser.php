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
                            {--email : User email address}
                            {--name : User name}
                            {--pass : User password}';

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
        $options = $this->options();
        if (!$options['email']) {
            $options['email'] = $this->ask('Enter an email address for the user');
        }
        if (!$options['name']) {
            $options['name'] = $this->ask('Enter a name for the user');
        }
        if (!$options['pass']) {
            $options['pass'] = $this->secret('Enter a password for the user');
            $password_confirm = $this->secret('Re-type the password to confirm');
            if ($options['pass'] !== $password_confirm) {
                $this->error('Passwords did not match.');
                return 1;
            }
        }

        if (empty($options['email']) || empty($options['name']) || empty($options['pass'])) {
            $this->error('All options (name, email, and password) are required.');
            return 1;
        }

        // Validate email.
        $validator = Validator::make(['email' => $options['email']], [
            'email' => 'email',
        ]);
        if ($validator->fails()) {
            $this->error("Invalid email address {$options['email']}.");
            return 1;
        }

        // Check for an existing user.
        if (User::whereEmail($options['email'])->exists()) {
            $this->error("User with email address {$options['email']} already exists.");
            return 1;
        }

        User::create([
            'name' => $options['name'],
            'email' => $options['email'],
            'password' => Hash::make($options['pass']),
            'remember_token' => Str::random(10),
        ])->save();

        $this->info("User {$options['email']} created!");

        return 0;
    }
}
