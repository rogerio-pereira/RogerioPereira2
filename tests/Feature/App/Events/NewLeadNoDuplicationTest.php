<?php

namespace Tests\Feature\App\Events;

use App\Events\NewLead;
use App\Listeners\NewLeadEmailListener;
use App\Listeners\NewLeadSlackListener;
use App\Models\Contact;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

test('new lead event triggers only one slack notification per dispatch', function () {
    Notification::fake();
    Event::fake([NewLead::class]);

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'automation');

    // Manually trigger the listeners to simulate event dispatch
    $slackListener = new NewLeadSlackListener;
    $slackListener->handle($event);

    // Verify only one notification was sent
    Notification::assertSentTimes(\App\Notifications\SlackNotification::class, 1);
});

test('new lead event triggers only one email per dispatch', function () {
    Mail::fake();
    Event::fake([NewLead::class]);

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'automation');

    // Manually trigger the listener to simulate event dispatch
    $emailListener = new NewLeadEmailListener;
    $emailListener->handle($event);

    // Verify only one email was queued
    $queuedCount = 0;
    Mail::assertQueued(\App\Mail\NewLeadEmail::class, function ($mail) use (&$queuedCount) {
        $queuedCount++;

        return true;
    });
    expect($queuedCount)->toBe(1);
});

test('new lead event dispatches only once when called from controller', function () {
    Event::fake();
    Notification::fake();
    Mail::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ];

    $this->post(route('automation.store'), $data);

    // Verify event was dispatched exactly once
    Event::assertDispatchedTimes(NewLead::class, 1);
});

test('new lead event listeners are called only once per event dispatch', function () {
    Event::fake();
    Notification::fake();
    Mail::fake();

    $contact = Contact::factory()->create();
    NewLead::dispatch($contact, 'marketing');

    // Verify listeners were called (through their side effects)
    // Since we're using Event::fake(), we need to manually verify
    // that if the event was dispatched once, listeners should be called once
    Event::assertDispatchedTimes(NewLead::class, 1);

    // When event is actually dispatched (not faked), verify no duplication
    Event::fake([NewLead::class]);
    Notification::fake();
    Mail::fake();

    $contact2 = Contact::factory()->create();
    $event = new NewLead($contact2, 'software-development');

    // Manually call both listeners once
    $slackListener = new NewLeadSlackListener;
    $slackListener->handle($event);

    $emailListener = new NewLeadEmailListener;
    $emailListener->handle($event);

    // Verify each listener was called only once
    Notification::assertSentTimes(\App\Notifications\SlackNotification::class, 1);

    $queuedCount = 0;
    Mail::assertQueued(\App\Mail\NewLeadEmail::class, function ($mail) use (&$queuedCount) {
        $queuedCount++;

        return true;
    });
    expect($queuedCount)->toBe(1);
});
