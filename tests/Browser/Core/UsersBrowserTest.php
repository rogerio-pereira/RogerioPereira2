<?php

use App\Models\User;

beforeEach()->flaky();

it('shows the users admin screens to authenticated users', function (string $url, string $heading, ?string $submit) {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $page = visit($url)
                ->waitForEvent('networkidle')
                ->assertSee($heading);

    if ($submit !== null) {
        $page->assertPresent($submit);
    }
})->with([
    'index' => ['/core/users', 'Users', null],
    'create' => ['/core/users/create', 'New user', '@user-submit'],
]);

it('shows the users edit form to authenticated users', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $editable = User::factory()
                    ->create([
                        'name' => 'Casey Editor',
                    ]);

    $url = "/core/users/{$editable->id}/edit";

    visit($url)
        ->waitForEvent('networkidle')
        ->assertSee('Edit user')
        ->assertPresent('@user-submit');
});

it('creates a user from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    visit('/core/users/create')
        ->waitForEvent('networkidle')
        ->type('name', 'Riley Admin')
        ->type('email', 'riley@example.com')
        ->type('password', 'front-porch-secret')
        ->type('password_confirmation', 'front-porch-secret')
        ->click('@user-submit')
        ->waitForText('Riley Admin')
        ->assertPathIs('/core/users');

    $userExists = User::where('email', 'riley@example.com')
                    ->exists();

    expect($userExists)
        ->toBeTrue();
});

it('edits a user from the admin form', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $editable = User::factory()
                    ->create([
                        'name' => 'Casey Editor',
                        'email' => 'casey@example.com',
                    ]);

    visit("/core/users/{$editable->id}/edit")
        ->waitForEvent('networkidle')
        ->type('name', 'Casey Updated')
        ->click('@user-submit')
        ->waitForText('Casey Updated')
        ->assertPathIs('/core/users');

    $editable->refresh();

    $name = $editable->name;
    expect($name)->toBe('Casey Updated');
});

it('deletes a user from the admin index', function () {
    $user = User::factory()
                ->create();

    $this->actingAs($user);

    $deletable = User::factory()
                    ->create([
                        'name' => 'Delete Me',
                    ]);

    visit('/core/users')
        ->waitForEvent('networkidle')
        ->assertSee('Delete Me')
        ->click("@user-delete-{$deletable->id}")
        ->waitForEvent('networkidle')
        ->assertDontSee('Delete Me');

    expect(User::find($deletable->id))
        ->toBeNull();
});
