<?php

use App\Notifications\SlackNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

test('test slack message command sends notification with generic message', function () {
    $channel = '#test-channel';
    $env = config('app.env');
    $expectedMessage = 'Test message from Laravel in '.$env;

    Config::set('services.slack.notifications.channel', $channel);

    Artisan::call('slack:test');

    Notification::assertSentTimes(SlackNotification::class, 1);

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class,
        function ($notification) use ($expectedMessage) {
            $reflection = new \ReflectionClass($notification);
            $textProperty = $reflection->getProperty('text');
            $textProperty->setAccessible(true);

            return $textProperty->getValue($notification) === $expectedMessage;
        }
    );
});

test('test slack message command fails when channel is not configured', function () {
    Config::set('services.slack.notifications.channel', null);

    $exitCode = Artisan::call('slack:test');

    expect($exitCode)->toBe(Command::FAILURE);

    Notification::assertNothingSent();
});

test('test slack message command uses configured channel', function () {
    $channel = '#custom-channel';

    Config::set('services.slack.notifications.channel', $channel);

    Artisan::call('slack:test');

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class
    );
});

test('test slack message command includes environment in message for different environments', function (string $env) {
    Config::set('app.env', $env);
    $channel = '#test-channel';
    $expectedMessage = 'Test message from Laravel in '.$env;

    Config::set('services.slack.notifications.channel', $channel);

    Artisan::call('slack:test');

    Notification::assertSentTo(
        Notification::route('slack', $channel),
        SlackNotification::class,
        function ($notification) use ($expectedMessage) {
            $reflection = new \ReflectionClass($notification);
            $textProperty = $reflection->getProperty('text');
            $textProperty->setAccessible(true);

            return $textProperty->getValue($notification) === $expectedMessage;
        }
    );
})
    ->with([
        'testing',
        'production',
        'staging',
        'local',
    ]);

test('test slack message command handles exception when sending notification fails', function () {
    $channel = '#test-channel';

    Config::set('services.slack.notifications.channel', $channel);

    $originalDispatcher = app('Illuminate\Contracts\Notifications\Dispatcher');

    $dispatcher = \Mockery::mock('Illuminate\Contracts\Notifications\Dispatcher');
    $dispatcher->shouldReceive('send')
        ->once()
        ->andThrow(new \Exception('Slack exploded'));

    app()->instance('Illuminate\Contracts\Notifications\Dispatcher', $dispatcher);

    $exitCode = Artisan::call('slack:test');

    expect($exitCode)->toBe(Command::FAILURE);

    app()->instance('Illuminate\Contracts\Notifications\Dispatcher', $originalDispatcher);
    \Mockery::close();
});
