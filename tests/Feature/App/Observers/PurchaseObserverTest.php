<?php

namespace Tests\Feature\App\Observers;

use App\Events\PurchaseConfirmation;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Support\Facades\Event;

test('purchase observer increments ebook downloads when purchase is created', function () {
    Event::fake([PurchaseConfirmation::class]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 0,
    ]);

    $purchase = Purchase::create([
        'name' => 'Test Buyer',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    $ebook->refresh();

    expect($ebook->downloads)->toBe(1);
});

test('purchase observer increments ebook downloads multiple times for multiple purchases', function () {
    Event::fake([PurchaseConfirmation::class]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 0,
    ]);

    // Create first purchase
    Purchase::create([
        'name' => 'Buyer 1',
        'email' => 'buyer1@example.com',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    $ebook->refresh();
    expect($ebook->downloads)->toBe(1);

    // Create second purchase
    Purchase::create([
        'name' => 'Buyer 2',
        'email' => 'buyer2@example.com',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    $ebook->refresh();
    expect($ebook->downloads)->toBe(2);
});

test('purchase observer only increments when ebook relationship exists', function () {
    Event::fake([PurchaseConfirmation::class]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 5,
    ]);

    // Create purchase with valid ebook - should increment
    Purchase::create([
        'name' => 'Test Buyer',
        'email' => 'test@example.com',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    $ebook->refresh();
    expect($ebook->downloads)->toBe(6); // 5 + 1

    // The observer checks if ($purchase->ebook_id && $purchase->ebook)
    // So if ebook doesn't exist, it won't increment (which is the expected behavior)
});

test('purchase observer increments downloads even when ebook relationship is not loaded', function () {
    Event::fake([PurchaseConfirmation::class]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 5,
    ]);

    // Create purchase without loading the ebook relationship
    $purchase = Purchase::create([
        'name' => 'Test Buyer',
        'email' => 'test@example.com',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    // Verify the relationship is loaded and increment happened
    expect($purchase->ebook)->not->toBeNull();

    $ebook->refresh();
    expect($ebook->downloads)->toBe(6); // 5 + 1
});

test('purchase observer increments downloads for different ebooks independently', function () {
    Event::fake([PurchaseConfirmation::class]);

    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 0,
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'downloads' => 0,
    ]);

    Purchase::create([
        'name' => 'Buyer 1',
        'email' => 'buyer1@example.com',
        'ebook_id' => $ebook1->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    Purchase::create([
        'name' => 'Buyer 2',
        'email' => 'buyer2@example.com',
        'ebook_id' => $ebook2->id,
        'amount' => 39.99,
        'currency' => 'usd',
        'status' => 'completed',
        'completed_at' => now(),
    ]);

    $ebook1->refresh();
    $ebook2->refresh();

    expect($ebook1->downloads)->toBe(1);
    expect($ebook2->downloads)->toBe(1);
});
