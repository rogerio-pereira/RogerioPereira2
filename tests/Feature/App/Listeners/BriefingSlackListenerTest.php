<?php

namespace Tests\Feature\App\Listeners;

use App\Events\BriefingSubmitted;
use App\Listeners\BriefingSlackListener;
use App\Models\Briefing;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

test('briefing slack listener sends notification', function () {
    Notification::fake();

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingSlackListener;
    $listener->handle($event);

    Notification::assertSentTimes(\App\Notifications\SlackNotification::class, 1);
});

test('briefing slack listener sends notification with correct message', function () {
    Notification::fake();
    Config::set('services.slack.notifications.channel', '#test-channel');

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', '#test-channel'),
        SlackNotification::class
    );
});

test('briefing slack listener sends notification to configured channel', function () {
    Notification::fake();
    $channel = '#custom-channel';
    Config::set('services.slack.notifications.channel', $channel);

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingSlackListener;
    $listener->handle($event);

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class
    );
});
