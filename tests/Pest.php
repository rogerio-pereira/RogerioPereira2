<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a fake HTTP response for testing.
 *
 * @return \Illuminate\Http\Client\Response
 */
function fakeHttpResponse(array $data = [], int $status = 200)
{
    return \Illuminate\Support\Facades\Http::response($data, $status);
}

/**
 * Setup HTTP fake with multiple responses.
 *
 * Accepts an array where keys are URLs and values are either:
 * - An array with [data, status] format: ['url' => [[...data...], 200]]
 * - An array with 'data' and 'status' keys: ['url' => ['data' => [...], 'status' => 200]]
 * - A fakeHttpResponse instance: ['url' => $fakeResponse]
 * - A Closure/callable: ['url' => function($request) { ... }]
 *
 * @param  array  $responses  Array of URL => response data
 */
function fakeHttp(array $responses): void
{
    $fakeResponses = [];

    foreach ($responses as $url => $response) {
        // If it's already a fakeHttpResponse instance, use it directly
        if ($response instanceof \Illuminate\Http\Client\Response) {
            $fakeResponses[$url] = $response;

            continue;
        }

        // If it's a Closure/callable, use it directly
        if (is_callable($response) && ! is_array($response)) {
            $fakeResponses[$url] = $response;

            continue;
        }

        // If it's an array with [data, status] format
        if (is_array($response) && count($response) === 2 && is_array($response[0]) && is_int($response[1])) {
            $fakeResponses[$url] = fakeHttpResponse($response[0], $response[1]);

            continue;
        }

        // If it's an array with 'data' and 'status' keys
        if (is_array($response) && isset($response['data'])) {
            $status = $response['status'] ?? 200;
            $fakeResponses[$url] = fakeHttpResponse($response['data'], $status);

            continue;
        }

        // Default: treat as data with status 200
        $fakeResponses[$url] = fakeHttpResponse($response, 200);
    }

    \Illuminate\Support\Facades\Http::fake($fakeResponses);
}
