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

test('allows first form submission', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));
    $response->assertSessionHas('success');
    Event::assertDispatched(NewLead::class);
});

test('blocks second submission of same form on same day', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $firstResponse = $this->post(route('automation.store'), $data);
    $firstResponse->assertRedirect(route('automation.thank-you'));

    $secondResponse = $this->post(route('automation.store'), $data);
    $secondResponse->assertRedirect();
    $secondResponse->assertSessionHas('error', 'You have already submitted this form today. Please try again tomorrow.');
});

test('allows submission of different forms on same day', function () {
    Event::fake();

    $automationData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $marketingData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $softwareDevData = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

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

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

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

test('blocks IP for 7 days after third submission', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

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

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

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

    $today = Carbon::today()->format('Y-m-d');
    $domainKey = "form_submission_domain:{$ipAddress}:gmail.com:{$today}";
    Cache::put($domainKey, 3, now()->addDay());

    $data = [
        'name' => 'John Doe',
        'email' => 'john4@gmail.com',
        'captcha' => '',
    ];

    $response = $this->post(route('automation.store'), $data);
    $response->assertRedirect();
    $response->assertSessionHas('error', 'Suspicious activity detected. Please try again in 7 days.');
});

test('allows up to 3 emails from same domain per IP per day', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data1 = [
        'name' => 'John Doe',
        'email' => 'john1@gmail.com',
        'captcha' => '',
    ];

    $data2 = [
        'name' => 'Jane Doe',
        'email' => 'jane@gmail.com',
        'captcha' => '',
    ];

    $data3 = [
        'name' => 'Bob Doe',
        'email' => 'bob@gmail.com',
        'captcha' => '',
    ];

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

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => '192.168.1.1']);
    $response1 = $this->post(route('automation.store'), $data);
    $response1->assertRedirect(route('automation.thank-you'));

    Cache::flush();

    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => '192.168.1.2']);
    $response2 = $this->post(route('automation.store'), $data);
    $response2->assertRedirect(route('automation.thank-you'));

    Event::assertDispatched(NewLead::class, 2);
});

test('allows resubmission after midnight', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

    $today = Carbon::today();
    Carbon::setTestNow($today->copy()->setTime(23, 59, 59));

    $firstResponse = $this->post(route('automation.store'), $data);
    $firstResponse->assertRedirect(route('automation.thank-you'));

    $secondResponse = $this->post(route('automation.store'), $data);
    $secondResponse->assertSessionHas('error');

    Carbon::setTestNow($today->copy()->addDay()->setTime(0, 0, 1));

    $thirdResponse = $this->post(route('automation.store'), $data);
    $thirdResponse->assertRedirect(route('automation.thank-you'));

    Carbon::setTestNow();
});

test('blocks after third submission triggers 7 day block', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'captcha' => '',
    ];

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

test('email domain limit blocks after 3 submissions from same domain', function () {
    Event::fake();

    $ipAddress = '192.168.1.1';
    $this->from(route('automation'))->withServerVariables(['REMOTE_ADDR' => $ipAddress]);

    $data1 = ['name' => 'John', 'email' => 'john1@gmail.com', 'captcha' => ''];
    $data2 = ['name' => 'Jane', 'email' => 'jane@gmail.com', 'captcha' => ''];
    $data3 = ['name' => 'Bob', 'email' => 'bob@gmail.com', 'captcha' => ''];

    $this->post(route('automation.store'), $data1);
    $this->post(route('marketing.store'), $data2);
    $this->post(route('software-development.store'), $data3);

    $data4 = ['name' => 'Alice', 'email' => 'alice@gmail.com', 'captcha' => ''];
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

    $gmailData = ['name' => 'John', 'email' => 'john@gmail.com', 'captcha' => ''];
    $yahooData = ['name' => 'Jane', 'email' => 'jane@yahoo.com', 'captcha' => ''];
    $outlookData = ['name' => 'Bob', 'email' => 'bob@outlook.com', 'captcha' => ''];

    $response1 = $this->post(route('automation.store'), $gmailData);
    $response1->assertRedirect(route('automation.thank-you'));

    $response2 = $this->post(route('marketing.store'), $yahooData);
    $response2->assertRedirect(route('marketing.thank-you'));

    $response3 = $this->post(route('software-development.store'), $outlookData);
    $response3->assertRedirect(route('software-development.thank-you'));

    Event::assertDispatched(NewLead::class, 3);
});
