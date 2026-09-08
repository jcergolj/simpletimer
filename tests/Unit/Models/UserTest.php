<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(User::class)]
final class UserTest extends TestCase
{
    #[Test]
    public function automatic_password_rehash_keeps_the_password_verifiable(): void
    {
        $user = User::factory()->create();
        $user->forceFill(['password' => Hash::make('password')])->save();

        Auth::guard('web')->getProvider()->rehashPasswordIfRequired(
            $user->fresh(),
            ['password' => 'password'],
            true
        );

        $this->assertTrue(Hash::check('password', $user->fresh()->getAuthPassword()));
    }

    #[Test]
    public function authentication_uses_the_non_reusable_account_identity(): void
    {
        $user = User::factory()->create();

        $this->assertSame('account_uuid', $user->getAuthIdentifierName());
        $this->assertSame($user->account_uuid, $user->getAuthIdentifier());
    }

    #[Test]
    public function a_deleted_account_session_cannot_authenticate_a_replacement_account(): void
    {
        $deletedAccount = User::factory()->create();
        $sessionIdentity = $deletedAccount->getAuthIdentifier();
        $deletedAccountId = $deletedAccount->getKey();

        $deletedAccount->delete();

        $replacementAccount = User::factory()->create(['id' => $deletedAccountId]);

        $this->assertSame($deletedAccountId, $replacementAccount->getKey());
        $this->assertNotSame($sessionIdentity, $replacementAccount->getAuthIdentifier());
        $this->assertNull(Auth::guard('web')->getProvider()->retrieveById($sessionIdentity));
    }

    #[Test]
    public function repeated_logins_work_after_automatic_password_rehash(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password', ['rounds' => 4]),
        ]);

        $this->assertTrue(Auth::attempt([
            'email' => $user->email,
            'password' => 'password',
        ]));

        Auth::logout();

        $this->assertTrue(Auth::attempt([
            'email' => $user->email,
            'password' => 'password',
        ]));
    }
}
