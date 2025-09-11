<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Services\SubdomainUrlBuilder;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RegistrationSingleUserModeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function user_created_in_main_database_not_tenant_db(): void
    {
        $response = $this->withoutMiddleware()->post(route('register'), [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertValid()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);

        // Verify no tenant database was created
        $tenantDbPath = database_path('db/testuser.sqlite');
        $this->assertFileDoesNotExist($tenantDbPath);
    }

    #[Test]
    public function registration_redirects_to_main_domain_dashboard(): void
    {
        $response = $this->withoutMiddleware()->post(route('register'), [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertValid()
            ->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function second_user_registration_rejected(): void
    {
        // Create first user
        User::factory()->create(['username' => 'firstuser']);

        // Try to register second user
        $response = $this->post(route('register'), [
            'username' => 'seconduser',
            'email' => 'second@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertInvalid(['username']);
        $this->assertDatabaseMissing('users', ['username' => 'seconduser']);
    }

    #[Test]
    public function login_works_on_main_domain(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertValid()
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    #[Test]
    public function subdomain_urls_return_main_domain(): void
    {
        Config::set('app.url', 'http://localhost');

        $urlBuilder = app(SubdomainUrlBuilder::class);
        $url = $urlBuilder->build('testuser', '/dashboard');

        $this->assertEquals('http://localhost/dashboard', $url);
    }
}
