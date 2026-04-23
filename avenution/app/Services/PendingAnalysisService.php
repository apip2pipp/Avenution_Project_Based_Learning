<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class PendingAnalysisService
{
    private const PAYLOAD_KEY = 'pending_analysis_payload';
    private const TOKEN_KEY = 'pending_analysis_token';
    private const CACHE_PREFIX = 'pending_analysis:';
    private const OAUTH_STATE_PREFIX = 'pending-analysis:';
    private const TTL_MINUTES = 10;

    public function remember(Request $request, array $payload): void
    {
        $pendingToken = (string) Str::uuid();

        $request->session()->put(self::PAYLOAD_KEY, $payload);
        $request->session()->put(self::TOKEN_KEY, $pendingToken);

        Cache::put(self::CACHE_PREFIX . $pendingToken, $payload, now()->addMinutes(self::TTL_MINUTES));
        Cookie::queue(self::PAYLOAD_KEY, json_encode($payload), self::TTL_MINUTES);
        Cookie::queue(self::TOKEN_KEY, $pendingToken, self::TTL_MINUTES);
    }

    public function pull(Request $request): ?array
    {
        $sessionPayload = $request->session()->pull(self::PAYLOAD_KEY);
        $sessionToken = $request->session()->pull(self::TOKEN_KEY);
        $pendingTokens = $this->tokens($request, $sessionToken);

        $payload = $this->validPayload($sessionPayload)
            ?? $this->payloadFromCookie($request)
            ?? $this->payloadFromCacheTokens($pendingTokens);

        $this->clear($pendingTokens);

        return $payload;
    }

    public function token(Request $request): ?string
    {
        return $this->tokens($request)[0] ?? null;
    }

    private function tokens(Request $request, mixed $preferredToken = null): array
    {
        $sessionToken = $request->session()->get(self::TOKEN_KEY);
        $cookieToken = $request->cookie(self::TOKEN_KEY);
        $stateToken = $this->tokenFromOAuthState($request->query('state'));
        $tokens = [];

        foreach ([$preferredToken, $sessionToken, $cookieToken, $stateToken] as $token) {
            if (is_string($token) && $token !== '') {
                $tokens[] = $token;
            }
        }

        return array_values(array_unique($tokens));
    }

    public function oauthState(?string $token): ?string
    {
        if (! is_string($token) || $token === '') {
            return null;
        }

        return self::OAUTH_STATE_PREFIX . $token;
    }

    private function payloadFromCookie(Request $request): ?array
    {
        $cookiePayload = $request->cookie(self::PAYLOAD_KEY);

        if (! is_string($cookiePayload) || $cookiePayload === '') {
            return null;
        }

        $decoded = json_decode($cookiePayload, true);

        return $this->validPayload($decoded);
    }

    private function payloadFromCacheTokens(array $pendingTokens): ?array
    {
        foreach ($pendingTokens as $pendingToken) {
            $payload = $this->validPayload(Cache::pull(self::CACHE_PREFIX . $pendingToken));

            if ($payload) {
                return $payload;
            }
        }

        return null;
    }

    private function validPayload(mixed $payload): ?array
    {
        return is_array($payload) && ! empty($payload) ? $payload : null;
    }

    private function tokenFromOAuthState(mixed $state): ?string
    {
        if (! is_string($state) || ! str_starts_with($state, self::OAUTH_STATE_PREFIX)) {
            return null;
        }

        $token = substr($state, strlen(self::OAUTH_STATE_PREFIX));

        return $token !== '' ? $token : null;
    }

    private function clear(array $pendingTokens): void
    {
        Cookie::queue(Cookie::forget(self::PAYLOAD_KEY));
        Cookie::queue(Cookie::forget(self::TOKEN_KEY));

        foreach ($pendingTokens as $pendingToken) {
            Cache::forget(self::CACHE_PREFIX . $pendingToken);
        }
    }
}
