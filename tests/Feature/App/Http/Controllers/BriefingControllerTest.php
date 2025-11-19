<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Events\BriefingSubmitted;
use App\Models\Briefing;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

test('briefing create page can be accessed by anyone', function () {
    $response = $this->get(route('briefing.create'));

    $response->assertStatus(200);
    $response->assertViewIs('briefing.create');
});

test('briefing create page does not require authentication', function () {
    $response = $this->get(route('briefing.create'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('briefing thank you page can be accessed by anyone', function () {
    $response = $this->get(route('briefing.thank-you'));

    $response->assertStatus(200);
    $response->assertViewIs('briefing.thank-you');
});

test('briefing thank you page does not require authentication', function () {
    $response = $this->get(route('briefing.thank-you'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('briefing can be stored with valid data', function () {
    Event::fake();
    Mail::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
                'business_years' => '5 years',
            ],
            'problem' => [
                'main_problem' => 'Need to automate order processing',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertRedirect(route('briefing.thank-you'));
    $response->assertSessionHas('success', 'Thank you! We received your briefing and will analyze it soon.');

    $this->assertDatabaseHas('briefings', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'status' => 'new',
    ]);

    Event::assertDispatched(BriefingSubmitted::class, function ($event) {
        return $event->briefing->name === 'John Doe'
            && $event->briefing->email === 'john@example.com';
    });
});

test('briefing can be stored without phone', function () {
    Event::fake();
    Mail::fake();

    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'Services',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertRedirect(route('briefing.thank-you'));

    $this->assertDatabaseHas('briefings', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => null,
        'status' => 'new',
    ]);
});

test('briefing store converts nested array to expected format', function () {
    Event::fake();
    Mail::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
                'business_years' => '5 years',
            ],
            'problem' => [
                'main_problem' => 'Need automation',
            ],
        ],
    ];

    $this->post(route('briefing.store'), $data);

    $briefing = Briefing::where('email', 'test@example.com')->first();

    expect($briefing->briefing)->toBeArray();
    expect($briefing->briefing)->toHaveKey('sections');
    expect($briefing->briefing['sections'])->toHaveKey('business_info');
    expect($briefing->briefing['sections'])->toHaveKey('problem');
    expect($briefing->briefing['sections']['business_info'])->toBeArray();
    expect($briefing->briefing['sections']['business_info'][0])->toBe(['Business segment', 'E-commerce']);
    expect($briefing->briefing['sections']['business_info'][1])->toBe(['Business years', '5 years']);
    expect($briefing->briefing['sections']['problem'][0])->toBe(['Main problem', 'Need automation']);
});

test('briefing store requires name', function () {
    Event::fake();

    $data = [
        'email' => 'test@example.com',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('name');
    $this->assertDatabaseMissing('briefings', [
        'email' => 'test@example.com',
    ]);
});

test('briefing store requires email', function () {
    Event::fake();

    $data = [
        'name' => 'Test User',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseMissing('briefings', [
        'name' => 'Test User',
    ]);
});

test('briefing store requires valid email format', function () {
    Event::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'invalid-email',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('email');
});

test('briefing store requires briefing array', function () {
    Event::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('briefing');
    $this->assertDatabaseMissing('briefings', [
        'email' => 'test@example.com',
    ]);
});

test('briefing store validates phone max length', function () {
    Event::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => str_repeat('1', 21), // 21 characters, max is 20
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('phone');
});

test('briefing store validates name max length', function () {
    Event::fake();

    $data = [
        'name' => str_repeat('a', 256), // 256 characters, max is 255
        'email' => 'test@example.com',
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('name');
});

test('briefing store validates email max length', function () {
    Event::fake();

    $data = [
        'name' => 'Test User',
        'email' => str_repeat('a', 250).'@example.com', // Too long
        'briefing' => [
            'business_info' => [
                'business_segment' => 'E-commerce',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertSessionHasErrors('email');
});
