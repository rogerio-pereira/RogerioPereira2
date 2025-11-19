<?php

namespace Tests\Feature\App\Listeners;

use App\Events\PurchaseConfirmation;
use App\Listeners\PurchaseSlackListener;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

test('purchase slack listener handles event', function () {
    Notification::fake();
    Event::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', '#test-channel'),
        SlackNotification::class
    );
});

test('purchase slack listener sends notification for different amounts', function () {
    Notification::fake();
    Event::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $amounts = [29.99, 39.99, 49.99, 100.00];

    foreach ($amounts as $amount) {
        $purchase = Purchase::factory()->create([
            'ebook_id' => $ebook->id,
            'amount' => $amount,
            'status' => 'completed',
        ]);

        $event = new PurchaseConfirmation($purchase);
        $listener = new PurchaseSlackListener;
        $listener->handle($event);

        Notification::assertSentTo(
            Notification::route('slack', '#test-channel'),
            SlackNotification::class
        );
    }

    // Verify that 4 notifications were sent (one for each amount)
    Notification::assertCount(4);
});

test('purchase slack listener uses configured channel', function () {
    Notification::fake();
    Event::fake();
    $channel = '#custom-channel';
    Config::set('services.slack.notifications.channel', $channel);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'amount' => 39.99,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class
    );
});

test('purchase slack listener sends notification', function () {
    Notification::fake();
    Event::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::factory()->create([
        'ebook_id' => $ebook->id,
        'amount' => 123.45,
        'status' => 'completed',
    ]);

    $event = new PurchaseConfirmation($purchase);
    $listener = new PurchaseSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', '#test-channel'),
        SlackNotification::class
    );
});
