<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginScreenCanRendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testUserCanAuthenticateUsingLoginScreen()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUserCannotAuthenticateWithInvalidPassword()
    {
        $user = User::factory()->create();
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }

    public function testUserCanLogout()
    {
        $this->followingRedirects()->post('/logout');
        $this->assertGuest();
    }
}
