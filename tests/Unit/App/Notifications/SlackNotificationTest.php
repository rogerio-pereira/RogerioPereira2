<?php

namespace Tests\Unit\App\Notifications;

use App\Notifications\SlackNotification;
use Illuminate\Notifications\Slack\SlackMessage;

test('slack notification can be instantiated', function () {
    $text = 'Test notification';
    $notification = new SlackNotification($text);

    expect($notification)->toBeInstanceOf(SlackNotification::class);
});

test('slack notification returns slack channel via method', function () {
    $notification = new SlackNotification('Test');

    $via = $notification->via(new \stdClass);

    expect($via)->toBe(['slack']);
});

test('slack notification creates slack message with correct text', function () {
    $text = 'Test notification message';
    $notification = new SlackNotification($text);

    $notifiable = new \stdClass;
    $slackMessage = $notification->toSlack($notifiable);

    expect($slackMessage)->toBeInstanceOf(SlackMessage::class);

    // Use reflection to access the protected text property
    $reflection = new \ReflectionClass($slackMessage);
    $textProperty = $reflection->getProperty('text');
    $textProperty->setAccessible(true);
    $messageText = $textProperty->getValue($slackMessage);

    expect($messageText)->toBe($text);
});

test('slack notification handles different text messages', function () {
    $messages = [
        'New lead (automation)',
        'New lead (marketing)',
        'New lead (software-development)',
        'Custom message',
    ];

    foreach ($messages as $message) {
        $notification = new SlackNotification($message);
        $notifiable = new \stdClass;
        $slackMessage = $notification->toSlack($notifiable);

        expect($slackMessage)->toBeInstanceOf(SlackMessage::class);
    }
});
