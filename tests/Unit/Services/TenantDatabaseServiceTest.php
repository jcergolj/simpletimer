<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\TenantDatabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(TenantDatabaseService::class)]
final class TenantDatabaseServiceTest extends TestCase
{
    private TenantDatabaseService $tenantDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('app.domain', 'simpletimer.test');
        $this->tenantDatabase = app(TenantDatabaseService::class);
    }

    #[Test]
    public function main_domain_has_no_subdomain(): void
    {
        $subdomain = $this->tenantDatabase->extractSubdomain(
            Request::create('http://simpletimer.test')
        );

        $this->assertNull($subdomain);
    }

    #[Test]
    public function valid_tenant_host_returns_its_single_subdomain(): void
    {
        $subdomain = $this->tenantDatabase->extractSubdomain(
            Request::create('http://alice.simpletimer.test')
        );

        $this->assertSame('alice', $subdomain);
    }

    #[Test]
    public function unrelated_and_nested_hosts_are_not_tenants(): void
    {
        $unrelatedHost = $this->tenantDatabase->extractSubdomain(
            Request::create('http://alice.attacker.test')
        );

        $nestedHost = $this->tenantDatabase->extractSubdomain(
            Request::create('http://team.alice.simpletimer.test')
        );

        $this->assertNull($unrelatedHost);

        $this->assertNull($nestedHost);
    }
}
