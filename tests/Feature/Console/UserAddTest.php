<?php

namespace Tests\Feature\Console;

use App\Models\User;
use Tests\TestCase;

class UserAddTest extends TestCase
{

    public function testCanAddUserInteractively(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->makeOne();
        $this->artisan('user:add')
            ->expectsQuestion('Enter a username for the user', $user->username)
            ->expectsQuestion('Enter a password for the user (leave blank for a random password)', 'password')
            ->expectsQuestion('Re-type the password to confirm', 'password')
            ->expectsQuestion('Enter a name for the user (optional)', $user->name)
            ->assertExitCode(0);
        /** @var \App\Models\User $new_user */
        $new_user = User::whereUsername($user->username)->get()->first();
        $this->assertEquals($user->username, $new_user->username);
        $this->assertEquals($user->name, $new_user->name);
    }

    public function testCanAddUserWithArguments(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->makeOne();
        $parameters = [
            'username' => $user->username,
            'password' => 'password',
            '--name' => $user->name,
        ];
        $this->artisan('user:add', $parameters)
            ->assertExitCode(0);
        /** @var \App\Models\User $new_user */
        $new_user = User::whereUsername($user->username)->get()->first();
        $this->assertEquals($user->username, $new_user->username);
        $this->assertEquals($user->name, $new_user->name);
    }

    public function testCanNotAddExistingUsername(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->createOne(['username' => 'test_user']);
        $this->artisan('user:add', ['username' => $user->username])
            ->expectsOutput("User `{$user->username}` already exists.")
            ->assertExitCode(1);
    }

    public function testCanNotLeaveUsernameBlank(): void
    {
        /** @var \App\Models\User $user */
        $this->artisan('user:add')
            ->expectsQuestion('Enter a username for the user', NULL)
            ->expectsOutput('Username is required.')
            ->assertExitCode(1);
    }

    public function testPasswordsMustMatch(): void
    {
        /** @var \App\Models\User $user */
        $this->artisan('user:add', ['username' => 'test_user'])
            ->expectsQuestion('Enter a password for the user (leave blank for a random password)', 'password')
            ->expectsQuestion('Re-type the password to confirm', 'password1')
            ->expectsOutput('Passwords did not match.')
            ->assertExitCode(1);
    }

    public function testRandomPasswordCanBeGenerated(): void
    {
        /** @var \App\Models\User $user */
        $this->artisan('user:add', ['username' => 'test_user', '--name' => 'Test User'])
            ->expectsQuestion('Enter a password for the user (leave blank for a random password)', NULL)
            ->expectsOutput('User `test_user` added!')
            ->assertExitCode(0);
    }

}
