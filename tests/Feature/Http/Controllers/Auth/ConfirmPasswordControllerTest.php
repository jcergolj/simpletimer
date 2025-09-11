<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Requests\Auth\StoreConfirmPasswordRequest;
use App\Models\User;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ConfirmPasswordController::class)]
final class ConfirmPasswordControllerTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function auth_middleware_is_applied_for_confirm_password(): void
    {
        $response = $this->get(route('password.confirm'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $this->post(route('password.confirm.store'));

        $this->assertContainsFormRequest(StoreConfirmPasswordRequest::class);
    }

    #[Test]
    public function confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('password.confirm'));

        $response->assertOk();
    }

    #[Test]
    public function throttle_middleware_is_applied_for_confirm_password_store(): void
    {
        $response = $this->post(route('password.confirm.store'));

        $response->assertMiddlewareIsApplied('throttle:6,1');
    }

    #[Test]
    public function user_can_confirm_password_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('password.confirm'))
            ->post(route('password.confirm.store'), [
                'password' => 'password',
            ]);

        $response->assertValid()
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('auth.password_confirmed_at');
    }

    #[Test]
    public function user_cannot_confirm_password_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('password.confirm'))
            ->post(route('password.confirm.store'), [
                'password' => 'wrong-password',
            ]);

        $response->assertInvalid(['password']);
    }

    #[Test]
    public function user_is_redirected_to_intended_url_after_confirmation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['url.intended' => route('clients.index')])
            ->post(route('password.confirm.store'), [
                'password' => 'password',
            ]);

        $response->assertRedirect(route('clients.index'));
    }
}
