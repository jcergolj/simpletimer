<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Settings\ProfileController;

use App\Http\Controllers\Settings\ProfileController;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Models\User;
use Jcergolj\FormRequestAssertions\TestableFormRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ProfileController::class)]
#[CoversMethod(ProfileController::class, 'update')]
final class UpdateTest extends TestCase
{
    use TestableFormRequest;

    #[Test]
    public function auth_middleware_is_applied(): void
    {
        $response = $this->put(route('settings.profile.update'));

        $response->assertMiddlewareIsApplied('auth');
    }

    #[Test]
    public function controller_has_form_request(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.profile.update'));

        $this->assertContainsFormRequest(UpdateProfileRequest::class);
    }

    #[Test]
    public function user_can_update_email(): void
    {
        $user = User::factory()->create(['email' => 'old@example.com']);

        $response = $this->actingAs($user)->put(route('settings.profile.update'), [
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect(route('settings.profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'new@example.com',
        ]);
    }

    #[Test]
    public function email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);
        $user = User::factory()->create(['email' => 'current@example.com']);

        $response = $this->actingAs($user)->put(route('settings.profile.update'), [
            'email' => 'existing@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function user_can_keep_same_email(): void
    {
        $user = User::factory()->create(['email' => 'same@example.com']);

        $response = $this->actingAs($user)->put(route('settings.profile.update'), [
            'email' => 'same@example.com',
        ]);

        $response->assertSessionDoesntHaveErrors('email');
    }
}
