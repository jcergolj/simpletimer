<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\MigrateTenantDatabases;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\TestCase;

#[CoversClass(MigrateTenantDatabases::class)]
final class MigrateTenantDatabasesTest extends TestCase
{
    #[Test]
    public function migration_path_is_relative_to_the_application_root(): void
    {
        File::shouldReceive('glob')
            ->once()
            ->with(database_path('db/*.sqlite'))
            ->andReturn([database_path('db/alice.sqlite')]);

        $command = new class extends MigrateTenantDatabases
        {
            public bool $usedRelativePath = false;

            public function call($command, array $arguments = []): int
            {
                $this->usedRelativePath = $command === 'migrate'
                    && $arguments['--path'] === 'database/migrations';

                return Command::SUCCESS;
            }
        };
        $command->setLaravel($this->app);

        $this->assertSame(Command::SUCCESS, $command->run(new ArrayInput([]), new NullOutput));
        $this->assertTrue($command->usedRelativePath);
    }
}
