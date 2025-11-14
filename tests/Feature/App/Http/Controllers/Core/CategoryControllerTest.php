<?php

namespace Tests\Feature\App\Http\Controllers\Core;

use App\Models\Category;
use App\Models\User;

test('guests cannot access categories index', function () {
    $response = $this->get(route('core.categories.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view categories index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Category::factory()->count(3)->create();

    $response = $this->get(route('core.categories.index'));

    $response->assertStatus(200);
    $response->assertViewIs('core.categories.index');
    $response->assertViewHas('categories');
});

test('guests cannot access create category page', function () {
    $response = $this->get(route('core.categories.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create category page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('core.categories.create'));

    $response->assertStatus(200);
    $response->assertViewIs('core.categories.form');
});

test('guests cannot store a category', function () {
    $response = $this->post(route('core.categories.store'), [
        'name' => 'Test Category',
        'color' => '#FF5733',
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can create a category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $categoryData = [
        'name' => 'Test Category',
        'color' => '#FF5733',
    ];

    $response = $this->post(route('core.categories.store'), $categoryData);

    $response->assertRedirect(route('core.categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'name' => 'Test Category',
        'color' => '#FF5733',
    ]);
});

test('category creation requires name field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'color' => '#FF5733',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category creation validates color format', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'name' => 'Test Category',
        'color' => 'invalid-color',
    ]);

    $response->assertSessionHasErrors(['color']);
});

test('category color must be valid hex color', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'name' => 'Test Category',
        'color' => '#GGGGGG',
    ]);

    $response->assertSessionHasErrors(['color']);
});

test('category can be created without color', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'name' => 'Test Category',
    ]);

    $response->assertRedirect(route('core.categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'name' => 'Test Category',
        'color' => null,
    ]);
});

test('guests cannot access edit category page', function () {
    $category = Category::factory()->create();

    $response = $this->get(route('core.categories.edit', $category));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit category page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->get(route('core.categories.edit', $category));

    $response->assertStatus(200);
    $response->assertViewIs('core.categories.form');
    $response->assertViewHas('category');
});

test('guests cannot update a category', function () {
    $category = Category::factory()->create();

    $response = $this->put(route('core.categories.update', $category), [
        'name' => 'Updated Category',
        'color' => '#00FF00',
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update a category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create([
        'name' => 'Original Name',
        'color' => '#FF0000',
    ]);

    $response = $this->put(route('core.categories.update', $category), [
        'name' => 'Updated Name',
        'color' => '#00FF00',
    ]);

    $response->assertRedirect(route('core.categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Name',
        'color' => '#00FF00',
    ]);
});

test('category update requires name field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->put(route('core.categories.update', $category), [
        'color' => '#FF5733',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category update validates color format', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->put(route('core.categories.update', $category), [
        'name' => 'Test Category',
        'color' => 'invalid-color',
    ]);

    $response->assertSessionHasErrors(['color']);
});

test('guests cannot delete a category', function () {
    $category = Category::factory()->create();

    $response = $this->delete(route('core.categories.destroy', $category));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete a category', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->delete(route('core.categories.destroy', $category));

    $response->assertRedirect(route('core.categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

test('category name must not exceed 255 characters', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'name' => str_repeat('a', 256),
        'color' => '#FF5733',
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('category color must not exceed 7 characters', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.categories.store'), [
        'name' => 'Test Category',
        'color' => '#FF57333',
    ]);

    $response->assertSessionHasErrors(['color']);
});

