<?php

namespace Tests\Unit;

use App\Services\PendingAnalysisService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PendingAnalysisServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_oauth_state_and_token_parsing()
    {
        $service = new PendingAnalysisService();

        $token = 'tkn123';
        $state = $service->oauthState($token);

        $this->assertStringContainsString($token, $state);

        $request = Request::create('/?state=' . $state, 'GET');
        $request->setLaravelSession(session());

        $this->assertSame($token, $service->token($request));
    }

    public function test_remember_puts_payload_to_session_and_cache()
    {
        Cache::flush();

        $service = new PendingAnalysisService();
        $payload = ['a' => 1, 'b' => 'x'];

        $request = Request::create('/', 'GET');
        $request->setLaravelSession(session());

        $service->remember($request, $payload);

        $this->assertNotEmpty($request->session()->get('pending_analysis_payload'));
        $token = $request->session()->get('pending_analysis_token');

        $this->assertIsString($token);
        $this->assertSame($payload, Cache::get('pending_analysis:' . $token));
    }

    public function test_pull_prefers_session_then_cookie_then_cache_and_clears()
    {
        Cache::flush();

        $service = new PendingAnalysisService();

        $sessionPayload = ['from' => 'session'];
        $cookiePayload = ['from' => 'cookie'];
        $cachePayload = ['from' => 'cache'];

        // session case
        $request = Request::create('/', 'GET');
        $request->setLaravelSession(session());
        $request->session()->put('pending_analysis_payload', $sessionPayload);
        $request->session()->put('pending_analysis_token', 'tsession');

        // also put cookie and cache to ensure precedence
        $cookieToken = 'tcookie';
        $cacheToken = 'tcache';
        Cache::put('pending_analysis:' . $cacheToken, $cachePayload);

        $requestWithCookie = Request::create('/', 'GET', [], ['pending_analysis_payload' => json_encode($cookiePayload), 'pending_analysis_token' => $cookieToken]);
        $requestWithCookie->setLaravelSession(session());

        // pull should return session payload when present
        $result = $service->pull($request);
        $this->assertSame($sessionPayload, $result);

        // now test cookie fallback
        $resultCookie = $service->pull($requestWithCookie);
        $this->assertSame($cookiePayload, $resultCookie);

        // now test cache fallback using oauth state
        $cacheToken = 'mycachetoken';
        Cache::put('pending_analysis:' . $cacheToken, $cachePayload);
        $state = $service->oauthState($cacheToken);
        $requestWithState = Request::create('/?state=' . $state, 'GET');
        $requestWithState->setLaravelSession(session());

        $resultCache = $service->pull($requestWithState);
        $this->assertSame($cachePayload, $resultCache);
        // ensure cache was cleared
        $this->assertNull(Cache::get('pending_analysis:' . $cacheToken));
    }
}
