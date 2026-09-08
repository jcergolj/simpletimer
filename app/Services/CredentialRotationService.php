<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class CredentialRotationService
{
    public function rotate(User $user, string $password): User
    {
        $user->forceFill([
            'account_uuid' => (string) Str::uuid(),
            'password' => $password,
            'password_reset_token' => null,
        ]);
        $user->setRememberToken(Str::random(60));
        $user->save();

        return $user;
    }
}
