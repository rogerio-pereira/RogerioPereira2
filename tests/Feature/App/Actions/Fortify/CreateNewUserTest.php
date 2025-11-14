<?php

namespace Tests\Feature\App\Actions\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

test('create new user successfully', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $user = $action->create($input);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals('John Doe', $user->name);
    $this->assertEquals('john@example.com', $user->email);
    $this->assertTrue(Hash::check('Password123!', $user->password));
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

test('create new user requires name field', function () {
    $action = new CreateNewUser;

    $input = [
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user requires email field', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user requires password field', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user validates email format', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user validates email uniqueness', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'existing@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user validates name max length', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => str_repeat('a', 256), // Exceeds max:255
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user validates email max length', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => str_repeat('a', 250).'@example.com', // Exceeds max:255
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user validates password rules', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'short', // Too short
        'password_confirmation' => 'short',
    ];

    $this->expectException(ValidationException::class);
    $action->create($input);
});

test('create new user accepts valid name at max length', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => str_repeat('a', 255), // Exactly max:255
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $user = $action->create($input);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals(str_repeat('a', 255), $user->name);
});

test('create new user accepts valid email at max length', function () {
    $action = new CreateNewUser;

    $email = str_repeat('a', 240).'@example.com'; // Exactly 255 characters
    $input = [
        'name' => 'John Doe',
        'email' => $email,
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $user = $action->create($input);

    $this->assertInstanceOf(User::class, $user);
    $this->assertEquals($email, $user->email);
});

test('create new user hashes password', function () {
    $action = new CreateNewUser;

    $input = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ];

    $user = $action->create($input);

    $this->assertNotEquals('Password123!', $user->password);
    $this->assertTrue(Hash::check('Password123!', $user->password));
});
