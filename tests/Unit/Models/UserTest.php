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
}
