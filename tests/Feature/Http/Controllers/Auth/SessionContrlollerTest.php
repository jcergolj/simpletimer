<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SessionsController;
use App\Http\Requests\Auth\StoreSessionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(SessionsController::class)]
final class SessionContrlollerTest extends TestCase
{
    use TestableFormRequest;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('app.single_user_mode', true);
    }

    #[Test]
    public function guest_middleware_is_applied_for_login(): void
    {
        $response = $this->get(route('login'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $this->post(route('login'));

        $this->assertContainsFormRequest(StoreSessionRequest::class);
    }

    #[Test]
    public function login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    #[Test]
    public function users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('login'))->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertValid()
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    #[Test]
    public function users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertInvalid();
        $this->assertGuest();
    }

    #[Test]
    public function users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('dashboard'))
            ->post(route('logout'));

        $response->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
