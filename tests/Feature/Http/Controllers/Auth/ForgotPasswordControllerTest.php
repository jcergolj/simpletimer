<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ForgotPasswordController::class)]
final class ForgotPasswordControllerTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function guest_middleware_is_applied_for_forgot_password(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
    }

    #[Test]
    public function guest_middleware_is_applied_for_forgot_password_store(): void
    {
        $response = $this->post(route('password.email'));

        $response->assertMiddlewareIsApplied('guest');
    }

    #[Test]
    public function throttle_middleware_is_applied_for_forgot_password_store(): void
    {
        $response = $this->post(route('password.email'));

        $response->assertMiddlewareIsApplied('throttle:3,1');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $this->post(route('password.email'));

        $this->assertContainsFormRequest(ForgotPasswordRequest::class);
    }

    #[Test]
    public function reset_link_is_sent_to_existing_user(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email,
            ]);

        $response->assertFound()
            ->assertRedirect(route('password.request'));

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    #[Test]
    public function reset_link_is_not_sent_to_non_existing_user(): void
    {
        Notification::fake();

        $response = $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'nonexistent@example.com',
            ]);

        $response->assertFound()
            ->assertRedirect(route('password.request'));

        Notification::assertNothingSent();
    }
}
