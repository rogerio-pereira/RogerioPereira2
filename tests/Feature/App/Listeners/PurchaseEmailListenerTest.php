<?php

namespace Tests\Feature\App\Listeners;

use App\Events\PurchaseConfirmation;
use App\Listeners\PurchaseEmailListener;
use App\Mail\EbookDownloadEmail;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('purchase email listener sends email for automation category', function () {
    Mail::fake();

    $category = Category::factory()->create(['name' => 'Automation']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    Mail::assertQueued(EbookDownloadEmail::class, function ($mail) use ($purchase) {
        return $mail->purchase->id === $purchase->id
            && $mail->hasTo($purchase->email);
    });
});

test('purchase email listener sends email for marketing category', function () {
    Mail::fake();

    $category = Category::factory()->create(['name' => 'Marketing']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    Mail::assertQueued(EbookDownloadEmail::class, function ($mail) use ($purchase) {
        return $mail->purchase->id === $purchase->id
            && $mail->hasTo($purchase->email);
    });
});

test('purchase email listener sends email for software development category', function () {
    Mail::fake();

    $category = Category::factory()->create(['name' => 'Software Development']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    Mail::assertQueued(EbookDownloadEmail::class, function ($mail) use ($purchase) {
        return $mail->purchase->id === $purchase->id
            && $mail->hasTo($purchase->email);
    });
});

test('purchase email listener queues email', function () {
    Mail::fake();

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    Mail::assertQueued(EbookDownloadEmail::class);
});

test('purchase email listener sends to correct email address', function () {
    Mail::fake();

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'email' => 'test@example.com',
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    Mail::assertQueued(EbookDownloadEmail::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});

test('purchase email listener loads ebook relationship', function () {
    Mail::fake();

    $category = Category::factory()->create(['name' => 'Automation']);
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'status' => 'completed',
    ]);

    // Unload the ebook relationship
    $purchase->unsetRelation('ebook');

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseEmailListener;
    $listener->handle($event);

    // Verify that the listener loaded the relationship
    expect($purchase->relationLoaded('ebook'))->toBeTrue();
    expect($purchase->ebook)->not->toBeNull();

    Mail::assertQueued(EbookDownloadEmail::class);
});
