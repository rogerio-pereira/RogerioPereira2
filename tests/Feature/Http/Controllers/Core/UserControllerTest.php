<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->admin = User::factory()
                    ->create();

    $this->actingAs($this->admin);
});

it('lists the users', function () {
    $response = $this->get('/core/users');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/users/Index')
        ->has('users', 1)
        ->has('users.0', fn (Assert $user) => $user
            ->where('id', $this->admin->id)
            ->where('name', $this->admin->name)
            ->where('email', $this->admin->email)
            ->etc()
        )
    );
});

it('shows the form to create a user', function () {
    $response = $this->get('/core/users/create');

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/users/Form')
        ->where('user', null)
    );
});

it('creates a user with a hashed password', function () {
    $response = $this->post('/core/users', [
        'name' => 'Amelia Porch',
        'email' => 'amelia@example.com',
        'password' => 'front-porch-secret',
        'password_confirmation' => 'front-porch-secret',
    ]);

    $response->assertRedirect('/core/users');

    $user = User::where('email', 'amelia@example.com')
                ->firstOrFail();

    $name = $user->name;
    expect($name)->toBe('Amelia Porch');

    $passwordMatches = Hash::check('front-porch-secret', $user->password);
    expect($passwordMatches)->toBeTrue();
});

it('validates the user payload', function () {
    $response = $this->post('/core/users', [
        'name' => '',
        'email' => 'not-an-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
});

it('shows the form to edit a user', function () {
    $url = "/core/users/{$this->admin->id}/edit";

    $response = $this->get($url);

    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->component('core/users/Form')
        ->has('user', fn (Assert $user) => $user
            ->where('id', $this->admin->id)
            ->where('name', $this->admin->name)
            ->where('email', $this->admin->email)
            ->etc()
        )
    );
});

it('updates a user without changing the password', function () {
    $user = User::factory()
                ->create();

    $password = $user->password;

    $response = $this->put("/core/users/{$user->id}", [
        'name' => 'Renamed Person',
        'email' => 'renamed@example.com',
        'password' => '',
    ]);

    $response->assertRedirect('/core/users');

    $user->refresh();

    $name = $user->name;
    expect($name)->toBe('Renamed Person');

    $email = $user->email;
    expect($email)->toBe('renamed@example.com');

    $currentPassword = $user->password;
    expect($currentPassword)->toBe($password);
});

it('updates the password of a user when one is provided', function () {
    $user = User::factory()
                ->create();

    $response = $this->put("/core/users/{$user->id}", [
        'name' => $user->name,
        'email' => $user->email,
        'password' => 'another-long-secret',
        'password_confirmation' => 'another-long-secret',
    ]);

    $response->assertRedirect('/core/users');

    $user->refresh();

    $passwordMatches = Hash::check('another-long-secret', $user->password);
    expect($passwordMatches)->toBeTrue();
});

it('deletes another user', function () {
    $user = User::factory()
                ->create();

    $response = $this->delete("/core/users/{$user->id}");

    $response->assertRedirect('/core/users');

    $deleted = User::find($user->id);
    expect($deleted)->toBeNull();
});

it('refuses to delete the signed-in user', function () {
    $response = $this->delete("/core/users/{$this->admin->id}");

    $response->assertRedirect('/core/users');

    $admin = User::find($this->admin->id);
    expect($admin)->not->toBeNull();
});

it('has no detail page for users', function () {
    $response = $this->get("/core/users/{$this->admin->id}");

    $response->assertNotFound();
});
