<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OAuth2ClientCredentialsAuth
{
    protected string $baseUrl;

    protected string $clientId;

    protected string $clientSecret;

    protected string $tokenEndpoint;

    protected string $cacheKey;

    public function __construct(
        string $baseUrl,
        string $clientId,
        string $clientSecret,
        string $tokenEndpoint = '/oauth/v2/token',
        string $cacheKey = 'oauth2_access_token'
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->tokenEndpoint = $tokenEndpoint;
        $this->cacheKey = $cacheKey;
    }

    public function getAccessToken(): string
    {
        $cachedToken = Cache::get($this->cacheKey);

        if ($cachedToken !== null) {
            return $cachedToken;
        }

        return $this->requestNewAccessToken();
    }

    protected function requestNewAccessToken(): string
    {
        try {
            $tokenUrl = $this->baseUrl.$this->tokenEndpoint;
            $tokenData = [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ];

            $response = Http::asForm()->post($tokenUrl, $tokenData);

            if (! $response->successful()) {
                $errorBody = $response->body();
                throw new \RuntimeException(
                    "Failed to obtain OAuth2 access token: {$errorBody}"
                );
            }

            $responseData = $response->json();
            $accessToken = $responseData['access_token'] ?? null;
            $expiresIn = $responseData['expires_in'] ?? 3600;

            if ($accessToken === null) {
                throw new \RuntimeException('Access token not found in OAuth2 response');
            }

            $this->cacheAccessToken($accessToken, $expiresIn);

            return $accessToken;
        } catch (\Exception $e) {
            Log::error('OAuth2 token request failed', [
                'error' => $e->getMessage(),
                'base_url' => $this->baseUrl,
                'token_endpoint' => $this->tokenEndpoint,
            ]);

            throw new \RuntimeException(
                "Failed to authenticate with OAuth2: {$e->getMessage()}",
                0,
                $e
            );
        }
    }

    protected function cacheAccessToken(string $accessToken, int $expiresIn): void
    {
        $safetyMargin = 60;
        $cacheExpiration = now()->addSeconds($expiresIn - $safetyMargin);
        Cache::put($this->cacheKey, $accessToken, $cacheExpiration);
    }
}
