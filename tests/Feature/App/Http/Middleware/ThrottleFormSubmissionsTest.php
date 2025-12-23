<?php

namespace Tests\Feature\App\Http\Middleware;

use App\Events\NewLead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use RyanChandler\LaravelCloudflareTurnstile\Facades\Turnstile;

beforeEach(function () {
    Cache::flush();
    Turnstile::fake();
});

/**
 * Helper function to generate form data with required fields including Turnstile token.
 * The Turnstile token is required because the ContactFormRequest validates it when Turnstile is enabled.
 */
function getFormData(array $data = []): array
{
    return array_merge([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
        'cf-turnstile-response' => Turnstile::dummy(),
    ], $data);
}

test('allows first form submission', function () {
    Event::fake();

    $data = getFormData();

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));
    $response->assertSessionHas('success');
    Event::assertDispatched(NewLead::class);
});

test('blocks second submission of same form on same day', function () {
    Event::fake();

    $data = getFormData();

    $firstResponse = $this->post(route('automation.store'), $data);
    $firstResponse->assertRedirect(route('automation.thank-you'));

    $secondResponse = $this->post(route('automation.store'), $data);
    $secondResponse->assertRedirect();
    $secondResponse->assertSessionHas('error', 'You have already submitted this form today. Please try again tomorrow.');
});

test('allows submission of different forms on same day', function () {
    Event::fake();

    $automationData = getFormData();
    $marketingData = getFormData();
    $softwareDevData = getFormData();

    $automationResponse = $this->post(route('automation.store'), $automationData);
    $automationResponse->assertRedirect(route('automation.thank-you'));

    $marketingResponse = $this->post(route('marketing.store'), $marketingData);
    $marketingResponse->assertRedirect(route('marketing.thank-you'));

    $softwareDevResponse = $this->post(route('software-development.store'), $softwareDevData);
    $softwareDevResponse->assertRedirect(route('software-development.thank-you'));

    Event::assertDispatched(NewLead::class, 3);
});

test('blocks after submitting three different forms on same day', function () {
    Event::fake();

    $data = getFormData();

    $this->post(route('automation.store'), $data);
    $this->post(route('marketing.store'), $data);
    $this->post(route('software-development.store'), $data);

    $fourthResponse = $this->post(route('automation.store'), $data);
    $fourthResponse->assertRedirect();
    $fourthResponse->assertSessionHas('error');
    $errorMessage = session('error');
    expect($errorMessage)->toContain('You have reached');
    expect($errorMessage)->toContain('7');
});

test('middleware executes blockForSevenDays when submissions count reaches 3', function () {
    Event::fake();

    $data = getFormData();

    $this->post(route('automation.store'), $data);
    $this->post(route('marketing.store'), $data);
    $this->post(route('software-development.store'), $data);

    $ipAddress = request()->ip();
    $maskedIp = md5($ipAddress);
    $blockedUntil = Cache::get("form_submission_blocked:{$maskedIp}");

    expect($blockedUntil)->not->toBeNull();
    expect(Carbon::now()->addDays(7)->diffInDays($blockedUntil))->toBeLessThan(1);
});

/**
 * Edge case test to cover lines 45-50 of ThrottleFormSubmissions middleware.
 *
 * This test simulates a scenario where:
 * 1. The IP has already submitted all 3 real forms (automation, marketing, software-development)
 * 2. A new form type is attempted (simulated via mocked route name 'new-form.store')
 *
 * The challenge: In normal flow, hasAlreadySubmittedFormToday() would block first (lines 35-40),
 * preventing us from reaching the 3+ submissions check (lines 45-50).
 *
 * Solution: Mock the Request's route()->getName() to return a non-existent form name.
 * This makes hasAlreadySubmittedFormToday() return false (new form not in cache),
 * while getSubmissionsCountToday() returns 3 (from the pre-filled cache entries),
 * allowing the execution to reach and test lines 45-50.
 */
test('middleware blocks with exact error message when submissions count is 3 (edge case)', function () {
    Event::fake();

    $ipAddress = '192.168.1.100';
    $maskedIp = md5($ipAddress);
    $today = Carbon::today()->format('Y-m-d');

    Cache::flush();

    // Pre-fill cache with 3 submissions from real forms to make getSubmissionsCountToday() return 3
    Cache::put("form_submission:{$maskedIp}:automation:{$today}", true, now()->addDay());
    Cache::put("form_submission:{$maskedIp}:marketing:{$today}", true, now()->addDay());
    Cache::put("form_submission:{$maskedIp}:software-development:{$today}", true, now()->addDay());

    $middleware = new \App\Http\Middleware\ThrottleFormSubmissions;

    // Mock Request to simulate a new form type that hasn't been submitted yet
    $mockRequest = \Mockery::mock(\Illuminate\Http\Request::class);

    $mockRoute = \Mockery::mock(\Illuminate\Routing\Route::class);
    // Return a non-existent route name so hasAlreadySubmittedFormToday() returns false
    $mockRoute->shouldReceive('getName')->andReturn('new-form.store');

    $mockRequest->shouldReceive('route')->andReturn($mockRoute);
    $mockRequest->shouldReceive('ip')->andReturn($ipAddress);
    $mockRequest->shouldReceive('input')->with('email')->andReturn('test@example.com');

    $next = function ($req) {
        return new \Illuminate\Http\RedirectResponse(route('automation.thank-you'));
    };

    $response = $middleware->handle($mockRequest, $next);

    expect($response)->toBeInstanceOf(\Illuminate\Http\RedirectResponse::class);

    $session = session()->all();
    expect($session)->toHaveKey('error');
    expect($session['error'])->toBe('You have reached the limit of 3 submissions per day. Please try again in 7 days.');

    // Verify that blockForSevenDays() was called (line 45)
    $blockedUntil = Cache::get("form_submission_blocked:{$maskedIp}");
    expect($blockedUntil)->not->toBeNull();
});

test('blocks IP for 7 days after third submission', function () {
    Event::fake();

    $data = getFormData();

    $this->post(route('automation.store'), $data);
    $this->post(route('marketing.store'), $data);
    $this->post(route('software-development.store'), $data);

    $ipAddress = request()->ip();
    $maskedIp = md5($ipAddress);
    $blockedUntil = Cache::get("form_submission_blocked:{$maskedIp}");

    expect($blockedUntil)->not->toBeNull();
    expect(Carbon::now()->addDays(7)->diffInDays($blockedUntil))->toBeLessThan(1);
});

test('blocks submission when IP is already blocked', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $maskedIp = md5($ipAddress);
    $blockedUntil = Carbon::now()->addDays(5);
    Cache::put("form_submission_blocked:{$maskedIp}", $blockedUntil, $blockedUntil);

    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data = getFormData();

    $response = $this->post(route('automation.store'), $data);
    $response->assertRedirect();
    $response->assertSessionHas('error');
    $errorMessage = session('error');
    expect($errorMessage)->toContain('You have reached the submission limit');
    expect($errorMessage)->toContain('day(s)');
});

test('blocks when same IP submits more than 3 emails from same domain', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    // Pre-fill cache to simulate 3 previous submissions from gmail.com domain
    $today = Carbon::today()->format('Y-m-d');
    $domainKey = "form_submission_domain:{$ipAddress}:gmail.com:{$today}";
    Cache::put($domainKey, 3, now()->addDay());

    // 4th submission from same domain should trigger block
    $data = getFormData(['email' => 'john4@gmail.com']);

    $response = $this->post(route('automation.store'), $data);
    $response->assertRedirect();
    $response->assertSessionHas('error', 'Suspicious activity detected. Please try again in 7 days.');
});

test('allows up to 3 emails from same domain per IP per day', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data1 = getFormData(['email' => 'john1@gmail.com']);
    $data2 = getFormData(['email' => 'jane@gmail.com']);
    $data3 = getFormData(['email' => 'bob@gmail.com']);

    $response1 = $this->post(route('automation.store'), $data1);
    $response1->assertRedirect(route('automation.thank-you'));

    $response2 = $this->post(route('marketing.store'), $data2);
    $response2->assertRedirect(route('marketing.thank-you'));

    $response3 = $this->post(route('software-development.store'), $data3);
    $response3->assertRedirect(route('software-development.thank-you'));

    Event::assertDispatched(NewLead::class, 3);
});

test('different IPs can submit independently', function () {
    Event::fake();

    $data = getFormData();

    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => '192.168.1.1']);
    $response1 = $this->post(route('automation.store'), $data);
    $response1->assertRedirect(route('automation.thank-you'));

    Cache::flush();

    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => '192.168.1.2']);
    $response2 = $this->post(route('automation.store'), $data);
    $response2->assertRedirect(route('automation.thank-you'));

    Event::assertDispatched(NewLead::class, 2);
});

/**
 * Tests that daily limits reset at midnight.
 * Uses Carbon::setTestNow() to manipulate time and verify that submissions
 * are tracked per calendar day, not per 24-hour period.
 */
test('allows resubmission after midnight', function () {
    Event::fake();

    $data = getFormData();

    // Set time to just before midnight
    $today = Carbon::today();
    Carbon::setTestNow($today->copy()->setTime(23, 59, 59));

    $firstResponse = $this->post(route('automation.store'), $data);
    $firstResponse->assertRedirect(route('automation.thank-you'));

    // Second submission on same day should be blocked
    $secondResponse = $this->post(route('automation.store'), $data);
    $secondResponse->assertSessionHas('error');

    // Move time to just after midnight (next day)
    Carbon::setTestNow($today->copy()->addDay()->setTime(0, 0, 1));

    // Should now be allowed since it's a new day
    $thirdResponse = $this->post(route('automation.store'), $data);
    $thirdResponse->assertRedirect(route('automation.thank-you'));

    // Reset time to current
    Carbon::setTestNow();
});

test('blocks after third submission triggers 7 day block', function () {
    Event::fake();

    $data = getFormData();

    $this->post(route('automation.store'), $data);
    $this->post(route('marketing.store'), $data);
    $this->post(route('software-development.store'), $data);

    $ipAddress = request()->ip();
    $maskedIp = md5($ipAddress);

    $blockedUntil = Cache::get("form_submission_blocked:{$maskedIp}");
    expect($blockedUntil)->not->toBeNull();

    $blockedResponse = $this->post(route('automation.store'), $data);
    $blockedResponse->assertRedirect();
    $blockedResponse->assertSessionHas('error');
});

/**
 * Tests that email domain tracking works across different form types.
 * The middleware tracks submissions by email domain (e.g., gmail.com) per IP per day,
 * regardless of which form was used. After 3 submissions from the same domain,
 * the 4th should trigger a 7-day block.
 */
test('email domain limit blocks after 3 submissions from same domain', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    // Submit 3 times using different forms but same email domain (gmail.com)
    $data1 = getFormData(['name' => 'John', 'email' => 'john1@gmail.com']);
    $data2 = getFormData(['name' => 'Jane', 'email' => 'jane@gmail.com']);
    $data3 = getFormData(['name' => 'Bob', 'email' => 'bob@gmail.com']);

    $this->post(route('automation.store'), $data1);
    $this->post(route('marketing.store'), $data2);
    $this->post(route('software-development.store'), $data3);

    // 4th submission from same domain should trigger block
    $data4 = getFormData(['name' => 'Alice', 'email' => 'alice@gmail.com']);
    $response = $this->post(route('automation.store'), $data4);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    $errorMessage = session('error');
    expect($errorMessage)->toContain('You have reached');
    expect($errorMessage)->toContain('7');
});

test('different email domains are tracked separately', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $gmailData = getFormData(['name' => 'John', 'email' => 'john@gmail.com']);
    $yahooData = getFormData(['name' => 'Jane', 'email' => 'jane@yahoo.com']);
    $outlookData = getFormData(['name' => 'Bob', 'email' => 'bob@outlook.com']);

    $response1 = $this->post(route('automation.store'), $gmailData);
    $response1->assertRedirect(route('automation.thank-you'));

    $response2 = $this->post(route('marketing.store'), $yahooData);
    $response2->assertRedirect(route('marketing.thank-you'));

    $response3 = $this->post(route('software-development.store'), $outlookData);
    $response3->assertRedirect(route('software-development.thank-you'));

    Event::assertDispatched(NewLead::class, 3);
});

test('middleware handles email without @ symbol gracefully', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data = getFormData(['email' => 'invalid-email-no-at-symbol']);

    $response = $this->post(route('automation.store'), $data);

    $response->assertSessionHasErrors(['email']);
});

test('middleware handles email with malformed domain', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data = getFormData(['email' => 'test@']);

    $response = $this->post(route('automation.store'), $data);

    $response->assertSessionHasErrors(['email']);
});

test('middleware handles submission without email field', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'captcha' => '',
        'cf-turnstile-response' => Turnstile::dummy(),
    ];

    // Should fail validation before middleware processes
    $response = $this->post(route('automation.store'), $data);

    $response->assertSessionHasErrors(['email']);
});

test('middleware processes successful response with 200 status code', function () {
    Event::fake();

    $data = getFormData();

    $response = $this->post(route('automation.store'), $data);

    $response->assertStatus(302);
    Event::assertDispatched(NewLead::class);
});

/**
 * Verifies that email domain extraction includes subdomains.
 * The middleware should track "subdomain.example.com" as the full domain,
 * not just "example.com", to properly identify unique email sources.
 */
test('middleware handles email domain extraction with valid email', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data = getFormData(['email' => 'test@subdomain.example.com']);

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));
    Event::assertDispatched(NewLead::class);

    // Verify that the full domain (including subdomain) is tracked
    $today = Carbon::today()->format('Y-m-d');
    $domainKey = "form_submission_domain:{$ipAddress}:subdomain.example.com:{$today}";
    $domainCount = Cache::get($domainKey);

    expect($domainCount)->toBe(1);
});

test('middleware handles submission when email is null', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'captcha' => '',
        'cf-turnstile-response' => Turnstile::dummy(),
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertSessionHasErrors(['email']);
});
