<?php

namespace Tests\Unit\App\Mail;

use App\Mail\NewLeadEmail;
use App\Models\Contact;

test('new lead email can be instantiated', function () {
    $contact = new Contact([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    $category = 'automation';

    $email = new NewLeadEmail($contact, $category);

    expect($email->contact)->toBe($contact);
    expect($email->category)->toBe($category);
});

test('new lead email has correct subject for automation', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'automation');

    $envelope = $email->envelope();

    expect($envelope->subject)->toBe('Your Free Automation Guide - 10 Strategies to Save Hours Every Week');
});

test('new lead email has correct subject for marketing', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'marketing');

    $envelope = $email->envelope();

    expect($envelope->subject)->toBe('Your Free Marketing Strategy Guide - Compete with Bigger Budgets');
});

test('new lead email has correct subject for software development', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'software-development');

    $envelope = $email->envelope();

    expect($envelope->subject)->toBe('Let\'s Build Your Software Project Together');
});

test('new lead email uses correct view for automation', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'automation');

    $content = $email->content();

    expect($content->view)->toBe('emails.new-lead.automation');
});

test('new lead email uses correct view for marketing', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'marketing');

    $content = $email->content();

    expect($content->view)->toBe('emails.new-lead.marketing');
});

test('new lead email uses correct view for software development', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'software-development');

    $content = $email->content();

    expect($content->view)->toBe('emails.new-lead.software-development');
});

test('new lead email defaults to automation view for unknown category', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'unknown-category');

    $content = $email->content();

    expect($content->view)->toBe('emails.new-lead.automation');
});

test('new lead email has no attachments', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $email = new NewLeadEmail($contact, 'automation');

    $attachments = $email->attachments();

    expect($attachments)->toBeArray();
    expect($attachments)->toBeEmpty();
});
