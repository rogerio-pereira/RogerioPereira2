<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegistrationDisabledTest extends TestCase
{
    public function test_the_registration_screen_does_not_exist()
    {
        $response = $this->get('/register');

        $response->assertNotFound();
    }

    public function test_users_cannot_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertNotFound();
    }
}
