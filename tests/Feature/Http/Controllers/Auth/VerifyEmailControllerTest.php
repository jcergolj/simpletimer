<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(VerifyEmailController::class)]
final class VerifyEmailControllerTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied_for_verify_email_notice(): void
    {
        $response = $this->get(route('verification.notice'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function verify_email_notice_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertOk();
    }

    #[Test]
    public function auth_middleware_is_applied_for_resend_verification(): void
    {
        $response = $this->post(route('verification.resend'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function throttle_middleware_is_applied_for_resend_verification(): void
    {
        $response = $this->post(route('verification.resend'));

        $response->assertMiddlewareIsApplied('throttle:6,1');
    }

    #[Test]
    public function user_can_resend_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.resend'));

        $response->assertFound()
            ->assertRedirect(route('verification.notice'))
            ->assertSessionHas('verification-sent', true);

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    #[Test]
    public function verified_user_is_redirected_to_dashboard_when_resending(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('verification.resend'));

        $response->assertRedirect(route('dashboard'));
    }

    #[Test]
    public function auth_middleware_is_applied_for_verify_email(): void
    {
        $response = $this->get(route('verification.verify', ['id' => 1, 'hash' => 'test']));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function signed_middleware_is_applied_for_verify_email(): void
    {
        $response = $this->get(route('verification.verify', ['id' => 1, 'hash' => 'test']));

        $response->assertMiddlewareIsApplied('signed');
    }

    #[Test]
    public function throttle_middleware_is_applied_for_verify_email(): void
    {
        $response = $this->get(route('verification.verify', ['id' => 1, 'hash' => 'test']));

        $response->assertMiddlewareIsApplied('throttle:6,1');
    }

    #[Test]
    public function user_can_verify_email_with_valid_signature(): void
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1((string) $user->email)]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('dashboard'));

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);

        Event::assertDispatched(Verified::class);
    }

    #[Test]
    public function user_cannot_verify_email_with_invalid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(
            route('verification.verify', ['id' => $user->id, 'hash' => 'invalid-hash'])
        );

        $response->assertForbidden();

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    #[Test]
    public function already_verified_user_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1((string) $user->email)]
        );

        $response = $this->actingAs($user)->get($url);

        $response->assertRedirect(route('dashboard'));
    }
}
