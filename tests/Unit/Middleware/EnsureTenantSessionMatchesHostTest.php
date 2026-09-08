<?php

declare(strict_types=1);

namespace Tests\Unit\Middleware;

use App\Http\Middleware\EnsureTenantSessionMatchesHost;
use Illuminate\Http\Request;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

#[CoversClass(EnsureTenantSessionMatchesHost::class)]
final class EnsureTenantSessionMatchesHostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set([
            'app.single_user_mode' => false,
            'app.domain' => 'simpletimer.test',
        ]);
    }

    #[Test]
    public function a_session_can_access_its_tenant_host(): void
    {
        $request = $this->requestWithTenant('alice.simpletimer.test', 'alice');

        $response = app(EnsureTenantSessionMatchesHost::class)->handle($request, fn (): mixed => response('ok'));

        $this->assertSame(200, $response->getStatusCode());
    }

    #[Test]
    public function a_session_cannot_access_a_different_tenant_host(): void
    {
        $request = $this->requestWithTenant('bob.simpletimer.test', 'alice');

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Unauthorized access to this subdomain.');

        app(EnsureTenantSessionMatchesHost::class)->handle($request, fn (): mixed => response('ok'));
    }

    #[Test]
    public function tenant_session_validation_is_skipped_in_single_user_mode(): void
    {
        Config::set('app.single_user_mode', true);

        $request = $this->requestWithTenant('bob.simpletimer.test', 'alice');

        $response = app(EnsureTenantSessionMatchesHost::class)->handle($request, fn (): mixed => response('ok'));

        $this->assertSame(200, $response->getStatusCode());
    }

    private function requestWithTenant(string $host, string $tenant, Request $request): Request
    {
        $session = new Store('test', new ArraySessionHandler(120));
        $session->start();
        $session->put('tenant', $tenant);

        $request = $request->create("https://{$host}/dashboard");
        $request->setLaravelSession($session);

        return $request;
    }
}
