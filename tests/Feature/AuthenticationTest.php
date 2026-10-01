<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_a_hashed_user_and_redirects_to_dashboard(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jordan Rivera',
            'email' => 'jordan@example.test',
            'password' => 'correct-horse-battery-staple',
            'password_confirmation' => 'correct-horse-battery-staple',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'jordan@example.test']);
        $this->assertTrue(Hash::check('correct-horse-battery-staple', User::where('email', 'jordan@example.test')->firstOrFail()->password));
    }

    public function test_valid_credentials_open_dashboard_and_logout_ends_session(): void
    {
        $user = User::factory()->create(['password' => Hash::make('stockroom-password')]);

        $response = $this->post('/login', ['email' => $user->email, 'password' => 'stockroom-password']);

        $response->assertRedirect('/dashboard');
        $this->get('/dashboard')->assertSeeText('Your learning space');
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }
}
