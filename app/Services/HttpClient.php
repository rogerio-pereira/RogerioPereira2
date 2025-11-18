<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HttpClient
{
    protected string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $baseUrl = rtrim($baseUrl, '/');

        $this->baseUrl = $baseUrl;
    }

    /**
     * Get bearer token for authentication.
     * Override this method in child classes if authentication is needed.
     */
    protected function getBearerToken(): ?string
    {
        return null;
    }

    public function request(string $method, string $endpoint, array $data = [], array $query = []): array
    {
        $url = "{$this->baseUrl}/{$endpoint}";
        $http = $this->prepareHttpClient();

        if (! empty($query)) {
            $http = $http->withQueryParameters($query);
        }

        $response = $this->executeRequest($http, $method, $url, $data);

        return $response->json();
    }

    protected function prepareHttpClient(): \Illuminate\Http\Client\PendingRequest
    {
        $http = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $token = $this->getBearerToken();

        if ($token !== null) {
            $http = $http->withToken($token);
        }

        return $http;
    }

    protected function executeRequest(
        \Illuminate\Http\Client\PendingRequest $http,
        string $method,
        string $url,
        array $data
    ): \Illuminate\Http\Client\Response {
        $method = strtoupper($method);

        switch ($method) {
            case 'GET':
                return $http->get($url);
                break;
            case 'POST':
                return $http->post($url, $data);
                break;
            case 'PATCH':
                return $http->patch($url, $data);
                break;
            case 'PUT':
                return $http->put($url, $data);
                break;
            case 'DELETE':
                return $http->delete($url);
                break;
            default:
                throw new \InvalidArgumentException("Unsupported HTTP method: {$method}");
                break;
        }
    }
}
