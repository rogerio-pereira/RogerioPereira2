<?php

namespace Tests\Unit\App\Mail;

use App\Mail\BriefingConfirmationEmail;
use App\Models\Briefing;

test('briefing confirmation email can be instantiated', function () {
    $briefing = new Briefing([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $email = new BriefingConfirmationEmail($briefing);

    expect($email->briefing)->toBe($briefing);
    expect($email->briefing->name)->toBe('John Doe');
    expect($email->briefing->email)->toBe('john@example.com');
});

test('briefing confirmation email has correct subject', function () {
    $briefing = new Briefing([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new BriefingConfirmationEmail($briefing);

    $envelope = $email->envelope();

    expect($envelope->subject)->toBe('We Received Your Project Briefing - Analysis in Progress');
});

test('briefing confirmation email uses correct view', function () {
    $briefing = new Briefing([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new BriefingConfirmationEmail($briefing);

    $content = $email->content();

    expect($content->view)->toBe('emails.briefing.confirmation');
});

test('briefing confirmation email has no attachments', function () {
    $briefing = new Briefing([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new BriefingConfirmationEmail($briefing);

    $attachments = $email->attachments();

    expect($attachments)->toBeArray();
    expect($attachments)->toBeEmpty();
});

test('briefing confirmation email contains briefing data', function () {
    $briefing = new Briefing([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
    ]);

    $email = new BriefingConfirmationEmail($briefing);

    expect($email->briefing->name)->toBe('Jane Doe');
    expect($email->briefing->email)->toBe('jane@example.com');
    expect($email->briefing->phone)->toBe('+1234567890');
});
