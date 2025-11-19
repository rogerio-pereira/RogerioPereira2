<?php

namespace Tests\Feature\App\Listeners;

use App\Events\BriefingSubmitted;
use App\Listeners\BriefingEmailListener;
use App\Mail\BriefingConfirmationEmail;
use App\Models\Briefing;
use Illuminate\Support\Facades\Mail;

test('briefing email listener sends email', function () {
    Mail::fake();

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingEmailListener;
    $listener->handle($event);

    Mail::assertQueued(BriefingConfirmationEmail::class, function ($mail) use ($briefing) {
        return $mail->hasTo($briefing->email)
            && $mail->briefing->id === $briefing->id;
    });
});

test('briefing email listener queues email', function () {
    Mail::fake();

    $briefing = Briefing::factory()->create();
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingEmailListener;
    $listener->handle($event);

    Mail::assertQueued(BriefingConfirmationEmail::class);
});

test('briefing email listener sends to correct email address', function () {
    Mail::fake();

    $briefing = Briefing::factory()->create([
        'email' => 'test@example.com',
    ]);
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingEmailListener;
    $listener->handle($event);

    Mail::assertQueued(BriefingConfirmationEmail::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});

test('briefing email listener sends email with correct briefing data', function () {
    Mail::fake();

    $briefing = Briefing::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    $event = new BriefingSubmitted($briefing);

    $listener = new BriefingEmailListener;
    $listener->handle($event);

    Mail::assertQueued(BriefingConfirmationEmail::class, function ($mail) use ($briefing) {
        return $mail->briefing->name === 'John Doe'
            && $mail->briefing->email === 'john@example.com'
            && $mail->briefing->id === $briefing->id;
    });
});
