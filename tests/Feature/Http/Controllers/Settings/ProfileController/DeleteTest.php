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
#[CoversMethod(ProfileController::class, 'delete')]
final class DeleteTest extends TestCase
{
    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->get(route('settings.profile.delete'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function user_can_view_delete_confirmation_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('settings.profile.delete'));

        $response->assertOk();
    }
}
