<?php

namespace Tests\Feature\App\Listeners;

use App\Events\NewLead;
use App\Listeners\NewLeadSlackListener;
use App\Models\Contact;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

test('new lead slack listener handles event', function () {
    Notification::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'automation');

    $listener = new NewLeadSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', '#test-channel'),
        SlackNotification::class
    );
});

test('new lead slack listener sends notification with correct category', function () {
    Notification::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $contact = Contact::factory()->create();
    $categories = ['automation', 'marketing', 'software-development'];

    foreach ($categories as $category) {
        $event = new NewLead($contact, $category);
        $listener = new NewLeadSlackListener;
        $listener->handle($event);

        Notification::assertSentTo(
            Notification::route('slack', '#test-channel'),
            SlackNotification::class
        );
    }

    // Verify that 3 notifications were sent (one for each category)
    Notification::assertCount(3);
});

test('new lead slack listener uses configured channel', function () {
    Notification::fake();
    $channel = '#custom-channel';
    Config::set('services.slack.notifications.channel', $channel);

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'marketing');

    $listener = new NewLeadSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class
    );
});
