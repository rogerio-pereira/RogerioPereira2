<?php

test('registration screen can be rendered', function () {
    // Registration is disabled in config/fortify.php
    $this->markTestSkipped('Registration feature is disabled');

    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    // Registration is disabled in config/fortify.php
    $this->markTestSkipped('Registration feature is disabled');

    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
