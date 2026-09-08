<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\ResetUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(ResetUserPassword::class)]
final class ResetUserPasswordTest extends TestCase
{
    #[Test]
    public function command_sets_a_usable_password_from_the_option(): void
    {
        $user = User::factory()->create([
            'email' => 'reset@example.com',
            'password_reset_token' => 'outstanding-token',
        ]);
        $previousAccountUuid = $user->account_uuid;
        $previousRememberToken = $user->getRememberToken();

        $this->artisan('user:reset-password', [
            'email' => $user->email,
            '--password' => 'newpassword123',
        ])->assertExitCode(0);

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
        $user->refresh();

        $this->assertNotSame($previousAccountUuid, $user->account_uuid);
        $this->assertNotSame($previousRememberToken, $user->getRememberToken());
        $this->assertNull($user->password_reset_token);
        $this->assertNull(Auth::guard('web')->getProvider()->retrieveById($previousAccountUuid));
    }
}
