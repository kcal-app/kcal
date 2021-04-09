<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    public function testLoginScreenCanRendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testUserCanAuthenticateUsingLoginScreen(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUserCannotAuthenticateWithInvalidPassword(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }

    public function testUserCanLogout(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->post('/login', ['username' => $user->username, 'password' => 'password']);
        $this->assertAuthenticated();
        $this->followingRedirects()->post('/logout');
        $this->assertGuest();
    }

    public function testExcessiveLoginRequestsAreRateLimited(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        Event::fake();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'username' => $user->username,
                'password' => 'wrong-password',
            ]);
            if ($i < 5) {
                Event::assertNotDispatched(Lockout::class);
                continue;
            }
            Event::assertDispatched(Lockout::class);
        }
    }
}
