<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\EnsureTenantSessionMatchesHost;
use App\Models\User;
use App\Services\TenantDatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

#[CoversClass(EnsureTenantSessionMatchesHost::class)]
final class EnsureTenantUserTest extends TestCase
{
    #[Test]
    public function a_session_for_another_tenant_is_rejected(): void
    {
        Config::set('app.single_user_mode', false);
        Config::set('app.domain', 'simpletimer.test');

        $user = User::factory()->create(['username' => 'bob']);
        $request = Request::create('http://bob.simpletimer.test/dashboard');
        $request->setLaravelSession(app('session.store'));
        $request->setUserResolver(fn (): User => $user);
        $request->session()->put(TenantDatabaseService::SESSION_KEY, 'alice');

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Unauthorized access to this subdomain.');

        app(EnsureTenantSessionMatchesHost::class)->handle(
            $request,
            fn () => response('ok')
        );
    }

    #[Test]
    public function a_session_for_the_current_tenant_is_allowed(): void
    {
        Config::set('app.single_user_mode', false);
        Config::set('app.domain', 'simpletimer.test');

        $user = User::factory()->create(['username' => 'alice']);
        $request = Request::create('http://alice.simpletimer.test/dashboard');
        $request->setLaravelSession(app('session.store'));
        $request->setUserResolver(fn (): User => $user);
        $request->session()->put(TenantDatabaseService::SESSION_KEY, 'alice');
        $request->session()->put(TenantDatabaseService::ACCOUNT_SESSION_KEY, $user->account_uuid);

        $response = app(EnsureTenantSessionMatchesHost::class)->handle(
            $request,
            fn () => response('ok')
        );

        $this->assertSame(200, $response->getStatusCode());
    }
}
