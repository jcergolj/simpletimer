<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ResetPasswordController::class)]
final class ResetPasswordControllerTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function guest_middleware_is_applied_for_reset_password(): void
    {
        $response = $this->get(route('password.reset'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function signed_middleware_is_applied_for_reset_password(): void
    {
        $response = $this->get(route('password.reset'));

        $response->assertMiddlewareIsApplied('signed');
    }

    #[Test]
    public function reset_password_screen_can_be_rendered_with_valid_signature(): void
    {
        $user = User::factory()->create();

        $url = URL::temporarySignedRoute(
            'password.reset',
            now()->addHour(),
            ['email' => $user->email]
        );

        $response = $this->get($url);

        $response->assertOk();
    }

    #[Test]
    public function reset_password_screen_cannot_be_rendered_with_invalid_signature(): void
    {
        $response = $this->get(route('password.reset', ['email' => 'test@example.com']));

        $response->assertForbidden();
    }

    #[Test]
    public function guest_middleware_is_applied_for_reset_password_store(): void
    {
        $response = $this->post(route('password.update'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function signed_middleware_is_applied_for_reset_password_store(): void
    {
        $response = $this->post(route('password.update'));

        $response->assertMiddlewareIsApplied('signed');
    }

    #[Test]
    public function throttle_middleware_is_applied_for_reset_password_store(): void
    {
        $response = $this->post(route('password.update'));

        $response->assertMiddlewareIsApplied('throttle:5,1');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $this->post(route('password.update'));

        $this->assertContainsFormRequest(ResetPasswordRequest::class);
    }

    #[Test]
    public function user_can_reset_password_with_valid_signature(): void
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $url = URL::temporarySignedRoute(
            'password.update',
            now()->addHour(),
            ['email' => 'test@example.com']
        );

        $response = $this->post($url, [
            'email' => 'test@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('login'));

        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
    }

    #[Test]
    public function user_cannot_reset_password_with_invalid_signature(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('password.update', ['email' => $user->email]), [
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function user_cannot_reset_password_with_non_existing_email(): void
    {
        $url = URL::temporarySignedRoute(
            'password.update',
            now()->addHour(),
            ['email' => 'nonexistent@example.com']
        );

        $response = $this->from($url)->post($url, [
            'email' => 'nonexistent@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertFound()
            ->assertRedirect($url);
    }
}
