<?php

declare(strict_types=1);

namespace Tests\Unit\Providers;

use App\Providers\AuthServiceProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(AuthServiceProvider::class)]
final class AuthServiceProviderTest extends TestCase
{
    #[Test]
    public function the_auth_service_provider_is_registered(): void
    {
        $this->assertArrayHasKey(AuthServiceProvider::class, app()->getLoadedProviders());
    }
}
