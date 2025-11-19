<?php

namespace Tests\Feature\App\Events;

use App\Events\PurchaseConfirmation;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('purchase confirmation event can be instantiated with purchase', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);

    expect($event->purchase)->toBe($purchase)
        ->and($event->purchase->id)->toBe($purchase->id);
});

test('purchase confirmation event has correct purchase property', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'email' => 'test@example.com',
        'amount' => 99.99,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);

    expect($event->purchase->email)->toBe('test@example.com')
        ->and((float) $event->purchase->amount)->toBe(99.99);
});

test('purchase confirmation event broadcastOn returns private channel', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $channels = $event->broadcastOn();

    expect($channels)->toBeArray()
        ->and($channels)->toHaveCount(1)
        ->and($channels[0])->toBeInstanceOf(PrivateChannel::class)
        ->and($channels[0]->name)->toBe('private-channel-name');
});

test('purchase confirmation event is serializable', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);

    // Test that the event can be serialized (for queue)
    $serialized = serialize($event);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBeInstanceOf(PurchaseConfirmation::class)
        ->and($unserialized->purchase->id)->toBe($purchase->id);
});
