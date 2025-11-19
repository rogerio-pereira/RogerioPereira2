<?php

namespace App\Console\Commands;

use App\Notifications\SlackNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

class TestSlackMessage extends Command
{
    protected $signature = 'slack:test';

    protected $description = 'Send a test message to Slack';

    public function handle(): int
    {
        $env = config('app.env');
        $message = 'Test message from Laravel in '.$env;

        $channel = Config::get('services.slack.notifications.channel');

        if (empty($channel)) {
            $this->error('Slack channel is not configured.');

            return Command::FAILURE;
        }

        $this->info("Sending test message to Slack channel: {$channel}");

        try {
            Notification::route('slack', $channel)
                ->notify(new SlackNotification($message));

            $this->info('Message sent successfully!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send message: {$e->getMessage()}");

            return Command::FAILURE;
        }
    }
}
