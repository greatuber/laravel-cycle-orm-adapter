<?php

declare(strict_types=1);

namespace WayOfDev\Tests\Bridge\Laravel\Console\Commands\Migrations;

use Cycle\Database\Database;
use Cycle\Database\DatabaseInterface;
use WayOfDev\Tests\TestCase;

class RollbackCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_handle(): void
    {
        /** @var Database $database */
        $database = $this->app->make(DatabaseInterface::class);

        $this::assertSame([], $database->getTables());
        $this->artisanCall('cycle:migrate:init');

        $this::assertConsoleCommandOutputContainsStrings('cycle:migrate:rollback', ['--force' => true], 'No');

        $this->artisanCall('cycle:orm:migrate', ['--force' => true]);
        // @phpstan-ignore-next-line
        $this::assertCount(1, $database->getTables());

        $this->artisanCall('cycle:migrate', ['--force' => true]);
        $this::assertCount(4, $database->getTables());

        $this->artisanCall('cycle:migrate:rollback', ['--force' => true]);
        $this::assertCount(1, $database->getTables());
    }
}
