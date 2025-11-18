<?php

namespace Tests\Unit\App\Services;

use App\Services\OAuth2ClientCredentialsAuth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
});

test('oauth2 client credentials auth requests new token when cache is empty', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
            'token_type' => 'Bearer',
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/oauth/v2/token',
        'test_oauth_token'
    );

    $token = $auth->getAccessToken();

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/oauth/v2/token'
            && $request->method() === 'POST'
            && $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded')
            && $request->data()['client_id'] === 'test-client-id'
            && $request->data()['client_secret'] === 'test-client-secret'
            && $request->data()['grant_type'] === 'client_credentials';
    });

    expect($token)->toBe('test-access-token');
});

test('oauth2 client credentials auth uses cached token when available', function () {
    Http::fake();

    Cache::put('test_oauth_token', 'cached-token', now()->addHour());

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/oauth/v2/token',
        'test_oauth_token'
    );

    $token = $auth->getAccessToken();

    Http::assertNothingSent();

    expect($token)->toBe('cached-token');
});

test('oauth2 client credentials auth caches token with expiration', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
            'token_type' => 'Bearer',
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/oauth/v2/token',
        'test_oauth_token'
    );

    $token = $auth->getAccessToken();

    expect(Cache::get('test_oauth_token'))->toBe('test-access-token');
});

test('oauth2 client credentials auth applies safety margin to cache expiration', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
            'token_type' => 'Bearer',
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/oauth/v2/token',
        'test_oauth_token'
    );

    $token = $auth->getAccessToken();

    $cacheExpiration = Cache::get('test_oauth_token', null, now()->addSeconds(3540));
    expect($cacheExpiration)->not->toBeNull();
});

test('oauth2 client credentials auth handles base url with trailing slash', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com/',
        'test-client-id',
        'test-client-secret'
    );

    $token = $auth->getAccessToken();

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/oauth/v2/token';
    });

    expect($token)->toBe('test-access-token');
});

test('oauth2 client credentials auth throws exception when token request fails', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'error' => 'invalid_client',
            'error_description' => 'Client authentication failed',
        ], 401],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret'
    );

    expect(fn () => $auth->getAccessToken())
        ->toThrow(\RuntimeException::class, 'Failed to obtain OAuth2 access token');
});

test('oauth2 client credentials auth throws exception when access token is missing in response', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'expires_in' => 3600,
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret'
    );

    expect(fn () => $auth->getAccessToken())
        ->toThrow(\RuntimeException::class, 'Access token not found in OAuth2 response');
});

test('oauth2 client credentials auth uses custom token endpoint', function () {
    fakeHttp([
        'https://mautic.example.com/custom/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/custom/token'
    );

    $token = $auth->getAccessToken();

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/custom/token';
    });

    expect($token)->toBe('test-access-token');
});

test('oauth2 client credentials auth uses custom cache key', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-access-token',
            'expires_in' => 3600,
        ], 200],
    ]);

    $auth = new OAuth2ClientCredentialsAuth(
        'https://mautic.example.com',
        'test-client-id',
        'test-client-secret',
        '/oauth/v2/token',
        'custom_cache_key'
    );

    $token = $auth->getAccessToken();

    expect(Cache::get('custom_cache_key'))->toBe('test-access-token');
});
