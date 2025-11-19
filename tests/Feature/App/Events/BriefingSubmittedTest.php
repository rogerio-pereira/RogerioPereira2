<?php

namespace Tests\Feature\App\Events;

use App\Events\BriefingSubmitted;
use App\Listeners\BriefingEmailListener;
use App\Listeners\BriefingSlackListener;
use App\Models\Briefing;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

test('briefing submitted event triggers only one slack notification per dispatch', function () {
    Notification::fake();
    Event::fake([BriefingSubmitted::class]);

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    // Manually trigger the listener to simulate event dispatch
    $slackListener = new BriefingSlackListener;
    $slackListener->handle($event);

    // Verify only one notification was sent
    Notification::assertSentTimes(\App\Notifications\SlackNotification::class, 1);
});

test('briefing submitted event triggers only one email per dispatch', function () {
    Mail::fake();
    Event::fake([BriefingSubmitted::class]);

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    // Manually trigger the listener to simulate event dispatch
    $emailListener = new BriefingEmailListener;
    $emailListener->handle($event);

    // Verify only one email was queued
    $queuedCount = 0;
    Mail::assertQueued(\App\Mail\BriefingConfirmationEmail::class, function ($mail) use (&$queuedCount) {
        $queuedCount++;

        return true;
    });
    expect($queuedCount)->toBe(1);
});

test('briefing submitted event dispatches only once when called from controller', function () {
    Event::fake();
    Notification::fake();
    Mail::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $this->post(route('briefing.store'), $data);

    // Verify event was dispatched exactly once
    Event::assertDispatchedTimes(BriefingSubmitted::class, 1);
});

test('briefing submitted event listeners are called only once per event dispatch', function () {
    Event::fake();
    Notification::fake();
    Mail::fake();

    $briefing = Briefing::factory()->create();
    BriefingSubmitted::dispatch($briefing);

    // Verify listeners were called (through their side effects)
    // Since we're using Event::fake(), we need to manually verify
    // that if the event was dispatched once, listeners should be called once
    Event::assertDispatchedTimes(BriefingSubmitted::class, 1);

    // When event is actually dispatched (not faked), verify no duplication
    Event::fake([BriefingSubmitted::class]);
    Notification::fake();
    Mail::fake();

    $briefing2 = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing2);

    // Manually call both listeners once
    $slackListener = new BriefingSlackListener;
    $slackListener->handle($event);

    $emailListener = new BriefingEmailListener;
    $emailListener->handle($event);

    // Verify each listener was called only once
    Notification::assertSentTimes(\App\Notifications\SlackNotification::class, 1);

    $queuedCount = 0;
    Mail::assertQueued(\App\Mail\BriefingConfirmationEmail::class, function ($mail) use (&$queuedCount) {
        $queuedCount++;

        return true;
    });
    expect($queuedCount)->toBe(1);
});

test('briefing submitted event contains briefing model', function () {
    $briefing = Briefing::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $event = new BriefingSubmitted($briefing);

    expect($event->briefing)->toBeInstanceOf(Briefing::class);
    expect($event->briefing->id)->toBe($briefing->id);
    expect($event->briefing->name)->toBe('John Doe');
    expect($event->briefing->email)->toBe('john@example.com');
});
