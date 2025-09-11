<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\ProfileController;

use App\Http\Controllers\Settings\ProfileController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProfileController::class)]
#[CoversMethod(ProfileController::class, 'destroy')]
final class DestroyTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->post(route('settings.profile.destroy'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_delete_account_with_correct_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('settings.profile.destroy'), [
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function user_cannot_delete_account_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('settings.profile.destroy'), [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
