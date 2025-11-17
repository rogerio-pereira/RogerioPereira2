<?php

namespace Tests\Feature\App\Observers;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Support\Str;

test('ebook observer generates slug automatically when slug is empty', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Test E-book Name',
        'slug' => null,
    ]);

    $ebook->save();

    $this->assertNotNull($ebook->slug);
    $this->assertEquals('test-e-book-name', $ebook->slug);
});

test('ebook observer does not override manually provided slug', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Test E-book Name',
        'slug' => 'custom-slug',
    ]);

    $ebook->save();

    $this->assertEquals('custom-slug', $ebook->slug);
});

test('ebook observer generates slug directly from name without uniqueness validation', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Test E-book',
        'slug' => null,
    ]);

    $ebook->save();

    // Slug is generated directly from name without checking for uniqueness
    $this->assertEquals('test-e-book', $ebook->slug);
});

test('ebook observer handles special characters in name when generating slug', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Test E-book: Special Characters! @#$%',
        'slug' => null,
    ]);

    $ebook->save();

    $this->assertNotNull($ebook->slug);
    // Str::slug() converts @ to 'at', so we check the actual generated slug
    $expectedSlug = Str::slug('Test E-book: Special Characters! @#$%');
    $this->assertEquals($expectedSlug, $ebook->slug);
    $this->assertStringContainsString('test-e-book', $ebook->slug);
});

test('ebook observer handles empty name gracefully', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => '',
        'slug' => null,
    ]);

    $ebook->save();

    // If name is empty, slug should remain null
    $this->assertNull($ebook->slug);
});

test('ebook observer does not generate slug if slug is already set', function () {
    $category = Category::factory()->create();
    $customSlug = 'my-custom-slug-123';
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Different Name',
        'slug' => $customSlug,
    ]);

    $ebook->save();

    $this->assertEquals($customSlug, $ebook->slug);
    $this->assertNotEquals(Str::slug('Different Name'), $ebook->slug);
});

test('ebook observer handles unicode characters in name', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => 'Test E-book com Acentuação',
        'slug' => null,
    ]);

    $ebook->save();

    $this->assertNotNull($ebook->slug);
    // Slug should normalize unicode characters
    $this->assertStringContainsString('test-e-book', $ebook->slug);
});

test('ebook observer generates slug only on creating event', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'name' => 'Original Name',
        'slug' => 'original-slug',
    ]);

    $originalSlug = $ebook->slug;

    // Update name - slug should not change
    $ebook->update([
        'name' => 'Updated Name',
    ]);

    $ebook->refresh();
    $this->assertEquals($originalSlug, $ebook->slug);
    $this->assertNotEquals(Str::slug('Updated Name'), $ebook->slug);
});

test('ebook observer handles very long names when generating slug', function () {
    $category = Category::factory()->create();
    $longName = str_repeat('Test E-book ', 20).'Final';
    $ebook = Ebook::factory()->make([
        'category_id' => $category->id,
        'name' => $longName,
        'slug' => null,
    ]);

    $ebook->save();

    $this->assertNotNull($ebook->slug);
    $this->assertLessThanOrEqual(255, strlen($ebook->slug)); // Database limit
});
