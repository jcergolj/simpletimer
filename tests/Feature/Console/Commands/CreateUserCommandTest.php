<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\CreateUserCommand;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[CoversClass(CreateUserCommand::class)]
final class CreateUserCommandTest extends TestCase
{
    #[Test]
    public function command_creates_a_user_with_a_usable_password(): void
    {
        $this->artisan('app:create-user')
            ->expectsQuestion('What is your username? (3-20 characters, lowercase, a-z, 0-9, -, _)', 'cliuser')
            ->expectsQuestion('What is your email address?', 'cliuser@example.com')
            ->expectsQuestion('Enter your password', 'password123')
            ->expectsQuestion('Confirm your password', 'password123')
            ->expectsQuestion('What is your default hourly rate? (Optional, press Enter to skip)', '')
            ->assertExitCode(0);

        $user = User::where('email', 'cliuser@example.com')->first();

        $this->assertNotNull($user);

        $this->assertTrue(Hash::check('password123', $user->password));
    }
}
