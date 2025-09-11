<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\PasswordController;

use App\Http\Controllers\Settings\PasswordController;
use App\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(PasswordController::class)]
#[CoversMethod(PasswordController::class, 'edit')]
final class EditTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->get(route('settings.password.edit'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_password_edit_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.password.edit'));

        $response->assertOk();
    }
}
