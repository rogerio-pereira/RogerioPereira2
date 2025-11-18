<?php

namespace Tests\Unit\App\Services;

use App\Services\HttpClient;
use Illuminate\Support\Facades\Http;

test('http client makes get request with correct data', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [['success' => true], 200],
    ]);

    $client = new HttpClient('https://api.example.com');
    $response = $client->request('GET', 'endpoint');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.example.com/endpoint'
            && $request->method() === 'GET'
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json');
    });

    expect($response)->toBeArray()
        ->and($response['success'])->toBeTrue();
});

test('http client makes post request with correct data', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [['id' => 123], 201],
    ]);

    $client = new HttpClient('https://api.example.com');
    $data = ['name' => 'Test', 'value' => 100];
    $response = $client->request('POST', 'endpoint', $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://api.example.com/endpoint'
            && $request->method() === 'POST'
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json')
            && $request->data() === $data;
    });

    expect($response)->toBeArray()
        ->and($response['id'])->toBe(123);
});

test('http client makes patch request with correct data', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [['updated' => true], 200],
    ]);

    $client = new HttpClient('https://api.example.com');
    $data = ['name' => 'Updated Name'];
    $response = $client->request('PATCH', 'endpoint', $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://api.example.com/endpoint'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json')
            && $request->data() === $data;
    });

    expect($response)->toBeArray()
        ->and($response['updated'])->toBeTrue();
});

test('http client makes put request with correct data', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [['replaced' => true], 200],
    ]);

    $client = new HttpClient('https://api.example.com');
    $data = ['name' => 'Replaced Name'];
    $response = $client->request('PUT', 'endpoint', $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://api.example.com/endpoint'
            && $request->method() === 'PUT'
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json')
            && $request->data() === $data;
    });

    expect($response)->toBeArray()
        ->and($response['replaced'])->toBeTrue();
});

test('http client makes delete request', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [[], 204],
    ]);

    $client = new HttpClient('https://api.example.com');
    $response = $client->request('DELETE', 'endpoint');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.example.com/endpoint'
            && $request->method() === 'DELETE'
            && $request->hasHeader('Accept', 'application/json')
            && $request->hasHeader('Content-Type', 'application/json');
    });

    expect($response)->toBeArray();
});

test('http client includes query parameters in request', function () {
    fakeHttp([
        'https://api.example.com/endpoint?search=test&page=1' => [['results' => []], 200],
    ]);

    $client = new HttpClient('https://api.example.com');
    $query = ['search' => 'test', 'page' => 1];
    $response = $client->request('GET', 'endpoint', [], $query);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.example.com/endpoint?search=test&page=1'
            && $request->method() === 'GET';
    });

    expect($response)->toBeArray();
});

test('http client handles base url with trailing slash', function () {
    fakeHttp([
        'https://api.example.com/endpoint' => [['success' => true], 200],
    ]);

    $client = new HttpClient('https://api.example.com/');
    $response = $client->request('GET', 'endpoint');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.example.com/endpoint';
    });

    expect($response)->toBeArray();
});

test('http client throws exception for unsupported method', function () {
    $client = new HttpClient('https://api.example.com');

    expect(fn () => $client->request('INVALID', 'endpoint'))
        ->toThrow(\InvalidArgumentException::class, 'Unsupported HTTP method: INVALID');
});
