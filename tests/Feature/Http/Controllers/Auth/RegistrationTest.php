<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class RegistrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('app.single_user_mode', false);
    }

    #[Test]
    public function guest_middleware_is_applied(): void
    {
        $response = $this->get(route('register'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    #[Test]
    public function new_users_can_register(): void
    {
        $response = $this->withoutMiddleware()->post(route('register'), [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $appUrl = config('app.url');
        $parsedUrl = parse_url((string) $appUrl);
        $scheme = $parsedUrl['scheme'] ?? 'http';
        $host = $parsedUrl['host'] ?? 'localhost';
        $port = isset($parsedUrl['port']) ? ":{$parsedUrl['port']}" : '';
        $expectedRedirect = "{$scheme}://testuser.{$host}{$port}/dashboard";

        $response->assertValid()
            ->assertRedirect($expectedRedirect);
    }

    #[Test]
    public function registration_is_not_allowed_on_subdomains(): void
    {
        $response = $this->get('http://testuser.simpletimer.test/register');

        $response->assertRedirect('http://simpletimer.test/register');
    }

    #[Test]
    public function registration_post_is_not_allowed_on_subdomains(): void
    {
        $response = $this->post('http://testuser.simpletimer.test/register', [
            'username' => 'newuser',
            'email' => 'new@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('http://simpletimer.test/register');
    }
}
