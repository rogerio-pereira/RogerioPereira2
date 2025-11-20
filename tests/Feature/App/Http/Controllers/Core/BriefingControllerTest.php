<?php

namespace Tests\Feature\App\Http\Controllers\Core;

use App\Models\Briefing;
use App\Models\User;

test('guests cannot access briefings index', function () {
    $response = $this->get(route('core.briefings.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view briefings index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing1 = Briefing::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'status' => 'new',
    ]);

    $briefing2 = Briefing::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'status' => 'done',
    ]);

    $response = $this->get(route('core.briefings.index'));

    $response->assertStatus(200);
    $response->assertViewIs('core.briefings.index');
    $response->assertViewHas('briefings');
    $response->assertSee('John Doe');
    $response->assertSee('john@example.com');
    $response->assertSee('Jane Doe');
    $response->assertSee('jane@example.com');
});

test('briefings index paginates results', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Briefing::factory()->count(20)->create();

    $response = $this->get(route('core.briefings.index'));

    $response->assertStatus(200);
    $response->assertViewHas('briefings');
    expect($response->viewData('briefings')->count())->toBe(15);
});

test('guests cannot access briefing show page', function () {
    $briefing = Briefing::factory()->create();

    $response = $this->get(route('core.briefings.show', $briefing));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view briefing details', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1234567890',
        'status' => 'new',
        'briefing' => [
            'sections' => [
                'business_info' => [
                    ['Business segment', 'E-commerce'],
                    ['Team size', 'Just me'],
                ],
                'problem' => [
                    ['Main problem', 'Need automation'],
                ],
            ],
        ],
    ]);

    $response = $this->get(route('core.briefings.show', $briefing));

    $response->assertStatus(200);
    $response->assertViewIs('core.briefings.show');
    $response->assertViewHas('briefing');
    $response->assertSee('John Doe');
    $response->assertSee('john@example.com');
    $response->assertSee('+1234567890');
    $response->assertSee('E-commerce');
    $response->assertSee('Just me');
    $response->assertSee('Need automation');
});

test('briefing show page displays mark as done button for new briefings', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'status' => 'new',
    ]);

    $response = $this->get(route('core.briefings.show', $briefing));

    $response->assertStatus(200);
    $response->assertSee('Mark as Done');
});

test('briefing show page does not display mark as done button for done briefings', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'status' => 'done',
    ]);

    $response = $this->get(route('core.briefings.show', $briefing));

    $response->assertStatus(200);
    $response->assertDontSee('Mark as Done');
});

test('briefing show page hides empty fields and no values', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'briefing' => [
            'sections' => [
                'materials' => [
                    ['Logo', 'No'],
                    ['Domain', 'Yes'],
                    ['Domain name', ''],
                ],
            ],
        ],
    ]);

    $response = $this->get(route('core.briefings.show', $briefing));

    $response->assertStatus(200);
    $response->assertDontSee('Logo');
    $response->assertSee('Domain');
    $response->assertSee('Yes');
});

test('guests cannot mark briefing as done', function () {
    $briefing = Briefing::factory()->create();

    $response = $this->patch(route('core.briefings.mark-as-done', $briefing));

    $response->assertRedirect(route('login'));
});

test('authenticated users can mark briefing as done', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'status' => 'new',
    ]);

    $response = $this->patch(route('core.briefings.mark-as-done', $briefing));

    $response->assertRedirect(route('core.briefings.index'));
    $response->assertSessionHas('success', __('Briefing marked as done.'));

    $this->assertDatabaseHas('briefings', [
        'id' => $briefing->id,
        'status' => 'done',
    ]);
});

test('mark as done can be called multiple times safely', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create([
        'status' => 'new',
    ]);

    $this->patch(route('core.briefings.mark-as-done', $briefing));
    $this->assertDatabaseHas('briefings', [
        'id' => $briefing->id,
        'status' => 'done',
    ]);

    $response = $this->patch(route('core.briefings.mark-as-done', $briefing));

    $response->assertRedirect(route('core.briefings.index'));
    $this->assertDatabaseHas('briefings', [
        'id' => $briefing->id,
        'status' => 'done',
    ]);
});

test('briefing index displays mark as done button only for new briefings', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $newBriefing = Briefing::factory()->create([
        'status' => 'new',
    ]);

    $doneBriefing = Briefing::factory()->create([
        'status' => 'done',
    ]);

    $response = $this->get(route('core.briefings.index'));

    $response->assertStatus(200);
    // Check that the mark as done route appears in the form action for new briefing
    $response->assertSee(route('core.briefings.mark-as-done', $newBriefing), false);
    // Check that it doesn't appear for done briefing
    $response->assertDontSee(route('core.briefings.mark-as-done', $doneBriefing), false);
});

test('briefing index displays view button for all briefings', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $briefing = Briefing::factory()->create();

    $response = $this->get(route('core.briefings.index'));

    $response->assertStatus(200);
    // Check that the show route appears in the href for the view button
    $response->assertSee(route('core.briefings.show', $briefing), false);
});

test('briefing store saves human readable values', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'briefing' => [
            'business_info' => [
                'team_size' => 'Just me',
                'current_operation' => 'Fully manual',
            ],
            'timeline_budget' => [
                'budget_reserved' => 'Yes → I have an amount',
                'urgency' => 'I want to start this month',
                'can_participate' => 'Yes, daily',
                'prefer_meetings' => 'Yes, periodic meetings',
            ],
            'materials' => [
                'logo' => 'Yes',
                'domain' => 'No',
            ],
            'contact_info' => [
                'preferred_contact_method' => 'Email',
                'planning_to_hire' => 'Yes',
            ],
        ],
    ];

    $response = $this->post(route('briefing.store'), $data);

    $response->assertRedirect(route('briefing.thank-you'));

    $briefing = Briefing::where('email', 'john@example.com')->first();

    expect($briefing->briefing['sections']['business_info'])->toContain(['Team size', 'Just me']);
    expect($briefing->briefing['sections']['business_info'])->toContain(['Current operation', 'Fully manual']);
    expect($briefing->briefing['sections']['timeline_budget'])->toContain(['Budget reserved', 'Yes → I have an amount']);
    expect($briefing->briefing['sections']['timeline_budget'])->toContain(['Urgency', 'I want to start this month']);
    expect($briefing->briefing['sections']['timeline_budget'])->toContain(['Can participate', 'Yes, daily']);
    expect($briefing->briefing['sections']['timeline_budget'])->toContain(['Prefer meetings', 'Yes, periodic meetings']);
    expect($briefing->briefing['sections']['materials'])->toContain(['Logo', 'Yes']);
    expect($briefing->briefing['sections']['materials'])->toContain(['Domain', 'No']);
    expect($briefing->briefing['sections']['contact_info'])->toContain(['Preferred contact method', 'Email']);
    expect($briefing->briefing['sections']['contact_info'])->toContain(['Planning to hire', 'Yes']);
});

test('briefing store saves checkbox arrays as human readable values', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'briefing' => [
            'problem' => [
                'problem_impact' => ['Financial losses', 'Wasted time'],
            ],
            'project' => [
                'integrations' => ['WhatsApp', 'Online payments'],
            ],
        ],
    ];

    $this->post(route('briefing.store'), $data);

    $briefing = Briefing::where('email', 'john@example.com')->first();

    $problemImpact = collect($briefing->briefing['sections']['problem'])
        ->firstWhere(0, 'Problem impact');
    expect($problemImpact[1])->toBe(['Financial losses', 'Wasted time']);

    $integrations = collect($briefing->briefing['sections']['project'])
        ->firstWhere(0, 'Integrations');
    expect($integrations[1])->toBe(['WhatsApp', 'Online payments']);
});
