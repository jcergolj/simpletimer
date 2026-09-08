<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        $url = $this->signedResetUrl($user);

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
        $previousAccountUuid = $user->account_uuid;
        $previousRememberToken = $user->getRememberToken();

        $url = $this->signedResetUrl($user, 'password.update');

        $response = $this->post($url, [
            'email' => 'test@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect(route('login'));

        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
        $this->assertNotSame($previousAccountUuid, $user->account_uuid);
        $this->assertNotSame($previousRememberToken, $user->getRememberToken());
        $this->assertNull($user->password_reset_token);
        $this->assertNull(Auth::guard('web')->getProvider()->retrieveById($previousAccountUuid));
    }

    #[Test]
    public function signed_link_cannot_reset_a_different_email(): void
    {
        $linkOwner = User::factory()->create(['email' => 'link-owner@example.com']);
        $targetUser = User::factory()->create(['email' => 'target@example.com']);

        $url = URL::temporarySignedRoute(
            'password.update',
            now()->addHour(),
            ['email' => $linkOwner->email]
        );

        $response = $this->post($url, [
            'email' => $targetUser->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertUnauthorized();

        $this->assertFalse(Hash::check('NewPassword123!', $targetUser->fresh()->password));
    }

    #[Test]
    public function reset_link_can_only_be_used_once(): void
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $url = $this->signedResetUrl($user, 'password.update');

        $payload = [
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ];

        $this->post($url, $payload)->assertRedirect(route('login'));

        $response = $this->post($url, [
            ...$payload,
            'password' => 'AnotherPassword123!',
            'password_confirmation' => 'AnotherPassword123!',
        ]);

        $response->assertUnauthorized();

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
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
            ['email' => 'nonexistent@example.com', 'token' => 'token']
        );

        $response = $this->from($url)->post($url, [
            'email' => 'nonexistent@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertFound()
            ->assertRedirect($url);
    }

    private function signedResetUrl(User $user, string $route = 'password.reset'): string
    {
        $token = 'test-reset-token';

        $user->update([
            'password_reset_token' => hash('sha256', $token),
        ]);

        return URL::temporarySignedRoute(
            $route,
            now()->addHour(),
            ['email' => $user->email, 'token' => $token]
        );
    }
}
