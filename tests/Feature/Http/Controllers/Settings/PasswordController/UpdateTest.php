<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\PasswordController;

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(PasswordController::class)]
#[CoversMethod(PasswordController::class, 'update')]
final class UpdateTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->put(route('settings.password.update'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.password.update'));

        $this->assertContainsFormRequest(UpdatePasswordRequest::class);
    }

    #[Test]
    public function user_can_update_password_with_correct_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('settings.password.edit'));
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    #[Test]
    public function user_cannot_update_with_wrong_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    #[Test]
    public function password_confirmation_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('settings.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
