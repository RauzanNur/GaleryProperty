<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertSame('081234567890', auth()->user()->phone);
    }

    public function test_phone_number_must_contain_digits_only(): void
    {
        foreach (['0812-3456-7890', '+6281234567890', '08123abc890', '0812 3456 789', '12345'] as $invalidPhone) {
            $this->post('/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => $invalidPhone,
                'password' => 'password',
                'password_confirmation' => 'password',
            ])->assertSessionHasErrors('phone');
        }

        $this->assertGuest();
    }
}
